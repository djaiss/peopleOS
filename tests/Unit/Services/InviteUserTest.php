<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\Permission;
use App\Exceptions\PermissionException;
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

        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $invitedUser = (new InviteUser(
            user: $user,
            email: 'dwight@dundermifflin.com',
        ))->execute();

        $this->assertDatabaseHas('users', [
            'email' => 'dwight@dundermifflin.com',
            'permission' => Permission::MEMBER->value,
            'account_id' => $user->account_id,
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
                && $job->description === 'Invited dwight@dundermifflin.com to the account';
        });

        Mail::assertQueued(UserInvited::class);
    }

    #[Test]
    public function it_fails_if_user_is_not_administrator_or_hr(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::MEMBER->value,
        ]);

        $this->expectException(PermissionException::class);

        (new InviteUser(
            user: $user,
            email: 'dwight@dundermifflin.com',
        ))->execute();
    }

    #[Test]
    public function it_fails_if_email_already_exists(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        User::factory()->create([
            'email' => 'dwight@dundermifflin.com',
        ]);

        $this->expectException(UserAlreadyExistsException::class);

        (new InviteUser(
            user: $user,
            email: 'dwight@dundermifflin.com',
        ))->execute();
    }

    #[Test]
    public function hr_representative_can_invite_users(): void
    {
        Queue::fake();
        Mail::fake();

        $user = User::factory()->create([
            'permission' => Permission::HR->value,
        ]);

        $invitedUser = (new InviteUser(
            user: $user,
            email: 'dwight@dundermifflin.com',
        ))->execute();

        $this->assertDatabaseHas('users', [
            'email' => 'dwight@dundermifflin.com',
            'permission' => Permission::MEMBER->value,
            'account_id' => $user->account_id,
        ]);

        $this->assertInstanceOf(
            User::class,
            $invitedUser
        );
    }
}
