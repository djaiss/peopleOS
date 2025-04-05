<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use App\Services\DestroyPerson;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Tests\TestCase;

class DestroyPersonTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_person(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'can_be_deleted' => true,
        ]);

        (new DestroyPerson(
            user: $user,
            person: $person,
        ))->execute();

        $this->assertDatabaseMissing('persons', [
            'id' => $person->id,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'person_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted the person called Ross Geller';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyPerson(
            user: $user,
            person: $person,
        ))->execute();
    }

    #[Test]
    public function it_fails_if_person_cannot_be_deleted(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'can_be_deleted' => false,
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('This person cannot be deleted.');

        (new DestroyPerson(
            user: $user,
            person: $person,
        ))->execute();
    }
}
