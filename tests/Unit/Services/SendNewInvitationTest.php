<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Exceptions\UserAlreadyJoinedException;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Mail\UserInvited;
use App\Models\User;
use App\Services\SendNewInvitation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendNewInvitationTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_a_new_invitation(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        Queue::fake();
        Mail::fake();

        $user = User::factory()->create();

        $invitedUser = User::factory()->create([
            'email' => 'ross.geller@friends.com',
            'account_id' => $user->account_id,
        ]);

        $invitedUser = (new SendNewInvitation(
            user: $user,
            invitedUser: $invitedUser,
        ))->execute();

        $this->assertDatabaseHas('users', [
            'email' => 'ross.geller@friends.com',
            'account_id' => $user->account_id,
            'invited_at' => '2018-01-01 00:00:00',
        ]);

        $this->assertInstanceOf(
            User::class,
            $invitedUser,
        );

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
                return $job->action === 'user_invitation_resend'
                    && $job->user->id === $user->id
                    && $job->description === 'Resent invitation to ross.geller@friends.com';
            },
        );

        Mail::assertQueued(UserInvited::class);
    }

    #[Test]
    public function it_fails_if_invited_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();

        $invitedUser = User::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new SendNewInvitation(
            user: $user,
            invitedUser: $invitedUser,
        ))->execute();
    }

    #[Test]
    public function it_fails_if_invited_user_has_already_accepted_the_invitation(): void
    {
        $user = User::factory()->create();

        $invitedUser = User::factory()->create([
            'account_id' => $user->account_id,
            'invitation_accepted_at' => now(),
        ]);

        $this->expectException(UserAlreadyJoinedException::class);

        (new SendNewInvitation(
            user: $user,
            invitedUser: $invitedUser,
        ))->execute();
    }
}
