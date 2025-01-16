<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UserAlreadyJoinedException;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Mail\UserInvited;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendNewInvitation
{
    public function __construct(
        public User $user,
        public User $invitedUser,
    ) {}

    /**
     * Send a new invitation to a user to the account who is not yet registered.
     * If the user has already accepted the invitation, we can't send a new
     * invitation.
     */
    public function execute(): User
    {
        $this->validate();
        $this->sendInvitation();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->invitedUser;
    }

    private function validate(): void
    {
        if ($this->invitedUser->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }

        if ($this->invitedUser->invitation_accepted_at) {
            throw new UserAlreadyJoinedException();
        }
    }

    private function sendInvitation(): void
    {
        $temporarySignedRoute = URL::temporarySignedRoute(
            'invitations.accept', now()->addDays(3), ['user' => $this->invitedUser->id]
        );

        Mail::to($this->invitedUser->email)
            ->queue(new UserInvited($temporarySignedRoute));

        $this->invitedUser->update([
            'invited_at' => now(),
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'user_invitation_resend',
            description: 'Resent invitation to '.$this->invitedUser->email,
        );
    }
}
