<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\UserStatus;
use App\Exceptions\UserAlreadyExistsException;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Mail\UserInvited;
use App\Models\User;
use App\Services\InviteUser;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InviteUserTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_invites_a_user(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        Queue::fake();
        Mail::fake();

        $user = User::factory()->create();

        $invitedUser = (new InviteUser(
            user: $user,
            email: 'ross.geller@friends.com',
        ))->execute();

        $this->assertDatabaseHas('users', [
            'email' => 'ross.geller@friends.com',
            'account_id' => $user->account_id,
            'status' => UserStatus::INVITED->value,
            'invited_at' => '2018-01-01 00:00:00',
        ]);

        $this->assertInstanceOf(
            User::class,
            $invitedUser
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'user_invitation'
                && $job->user->id === $user->id
                && $job->description === 'Invited ross.geller@friends.com to the account';
        });

        Mail::assertQueued(UserInvited::class);
    }

    #[Test]
    public function it_fails_if_email_already_exists(): void
    {
        $user = User::factory()->create();

        User::factory()->create([
            'email' => 'ross.geller@friends.com',
        ]);

        $this->expectException(UserAlreadyExistsException::class);

        (new InviteUser(
            user: $user,
            email: 'ross.geller@friends.com',
        ))->execute();
    }
}
