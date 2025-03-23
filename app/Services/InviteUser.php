<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserStatus;
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
        if (User::where('email', $this->email)->exists()) {
            throw new UserAlreadyExistsException();
        }
    }

    private function createUser(): void
    {
        $this->invitedUser = User::create([
            'email' => $this->email,
            'invited_at' => now(),
            'account_id' => $this->user->account_id,
            'status' => UserStatus::INVITED->value,
        ]);
    }

    private function sendInvitation(): void
    {
        $temporarySignedRoute = URL::temporarySignedRoute(
            'invitation.accept', now()->addDays(3), ['user' => $this->invitedUser->id]
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
