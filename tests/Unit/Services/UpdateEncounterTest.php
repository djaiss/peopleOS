<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Encounter;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdateEncounter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateEncounterTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_an_encounter(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $encounter = Encounter::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $newSeenAt = Carbon::create(2024, 1, 1, 12, 0, 0);
        $newContext = 'At Central Perk';

        $updatedReport = (new UpdateEncounter(
            user: $user,
            person: $person,
            encounter: $encounter,
            seenAt: $newSeenAt,
            context: $newContext,
        ))->execute();

        $this->assertDatabaseHas('encounters', [
            'id' => $encounter->id,
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals('2024-01-01 12:00:00', $updatedReport->seen_at);
        $this->assertEquals('At Central Perk', $updatedReport->context);

        $this->assertInstanceOf(
            Encounter::class,
            $updatedReport
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdatePersonLastConsultedDate::class,
            callback: function (UpdatePersonLastConsultedDate $job) use ($person): bool {
                return $job->person->id === $person->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'encounter_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated having seen Ross Geller';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $encounter = Encounter::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->expectException(ModelNotFoundException::class);

        (new UpdateEncounter(
            user: $user,
            person: $person,
            encounter: $encounter,
            seenAt: now(),
            context: 'At Central Perk',
        ))->execute();
    }
}
