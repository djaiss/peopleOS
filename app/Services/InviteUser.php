<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Permission;
use App\Exceptions\PermissionException;
use App\Exceptions\UserAlreadyExistsException;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Mail\UserInvited;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class InviteUser
{
    private User $invitedUser;

    public function __construct(
        public User $user,
        public string $email,
    ) {}

    /**
     * Invite a user to the account.
     * We can't invite a user to the account if the email address is already in
     * use.
     * The user needs to have to be either an administrator or an HR
     * representative to invite a user to the account.
     */
    public function execute(): User
    {
        $this->validate();
        $this->createUser();
        $this->sendInvitation();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->invitedUser;
    }

    private function validate(): void
    {
        if (! in_array($this->user->permission, [
            Permission::ADMINISTRATOR->value,
            Permission::HR->value,
        ])) {
            throw new PermissionException();
        }

        if (User::where('email', $this->email)->exists()) {
            throw new UserAlreadyExistsException();
        }
    }

    private function createUser(): void
    {
        $this->invitedUser = User::create([
            'email' => $this->email,
            'invited_at' => now(),
            'permission' => Permission::MEMBER->value,
            'account_id' => $this->user->account_id,
        ]);
    }

    private function sendInvitation(): void
    {
        $temporarySignedRoute = URL::temporarySignedRoute(
            'invitations.accept', now()->addDays(3), ['user' => $this->invitedUser->id]
        );

        Mail::to($this->email)
            ->queue(new UserInvited($temporarySignedRoute));
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'user_invitation',
            description: 'Invited '.$this->email.' to the account',
        );
    }
}
