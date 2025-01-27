<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\UserStatus;
use App\Jobs\LogUserAction;
use App\Jobs\SetupAccount;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\CreateAccount;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateAccountTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_an_account(): void
    {
        $this->executeService();
    }

    private function executeService(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $user = (new CreateAccount(
            email: 'ross.geller@friends.com',
            password: 'johnny',
            firstName: 'Ross',
            lastName: 'Geller',
        ))->execute();

        $this->assertDatabaseHas('accounts', [
            'id' => $user->account_id,
            'trial_ends_at' => '2018-01-31 00:00:00',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $user->account_id,
            'email' => 'ross.geller@friends.com',
            'status' => UserStatus::ACTIVE->value,
            'timezone' => 'UTC',
        ]);

        $this->assertEquals('Ross', $user->first_name);
        $this->assertEquals('Geller', $user->last_name);

        $this->assertInstanceOf(
            User::class,
            $user
        );

        Queue::assertPushed(SetupAccount::class, fn ($job) => $job->user->id === $user->id);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'account_creation' && $job->user->id === $user->id;
        });
    }
}
