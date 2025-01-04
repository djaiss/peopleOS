<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\CreateAccount;
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

        $user = (new CreateAccount(
            email: 'dwight@dundermifflin.com',
            password: 'johnny',
            firstName: 'Dwight',
            lastName: 'Schrute',
            organizationName: 'Dunder Mifflin',
        ))->execute();

        $this->assertDatabaseHas('accounts', [
            'id' => $user->account->id,
            'name' => 'Dunder Mifflin',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'account_id' => $user->account_id,
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
            'email' => 'dwight@dundermifflin.com',
            'is_account_administrator' => true,
            'timezone' => 'UTC',
        ]);

        $this->assertInstanceOf(
            User::class,
            $user
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'account_creation' && $job->user->id === $user->id;
        });
    }
}
