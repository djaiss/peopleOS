<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Encounter;
use App\Models\Person;
use App\Models\User;
use App\Services\DestroyEncounter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyEncounterTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_an_encounter(): void
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

        (new DestroyEncounter(
            user: $user,
            encounter: $encounter,
        ))->execute();

        $this->assertDatabaseMissing('encounters', [
            'id' => $encounter->id,
        ]);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'encounter_deletion'
                && $job->user->id === $user->id
                && $job->description === 'Deleted having seen Ross Geller';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $encounter = Encounter::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyEncounter(
            user: $user,
            encounter: $encounter,
        ))->execute();
    }
}
