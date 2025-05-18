<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use App\Services\PruneAccount;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PruneAccountTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_prunes_an_account(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        (new PruneAccount(
            user: $user,
            account: $user->account,
        ))->execute();

        $this->assertDatabaseMissing('persons', [
            'id' => $person->id,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'account_pruning'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted all persons and related data from your account';
            },
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $account = User::factory()->create()->account;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User does not belong to account');

        (new PruneAccount(
            user: $user,
            account: $account,
        ))->execute();
    }
}
