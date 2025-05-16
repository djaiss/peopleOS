<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Encounter;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateEncounter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateEncounterTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_an_encounter(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::create(2024, 1, 1));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $seenAt = Carbon::now();

        $report = (new CreateEncounter(
            user: $user,
            person: $person,
            seenAt: $seenAt,
            context: 'morning',
        ))->execute();

        $this->assertDatabaseHas('encounters', [
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'seen_at' => $seenAt,
        ]);

        $this->assertInstanceOf(
            Encounter::class,
            $report
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
                return $job->action === 'encounter_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Logged having seen Ross Geller';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new CreateEncounter(
            user: $user,
            person: $person,
            seenAt: Carbon::now(),
        ))->execute();
    }
}
