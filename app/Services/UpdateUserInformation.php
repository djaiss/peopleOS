<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class UpdateUserInformation
{
    public function __construct(
        public User $user,
        public string $email,
        public string $firstName,
        public string $lastName,
    ) {}

    /**
     * Update the user information.
     * If the email has changed, we need to send a new verification email to
     * verify the new email address.
     */
    public function execute(): User
    {
        $previousEmail = $this->user->email;
        if ($previousEmail !== $this->email) {
            $this->user->email_verified_at = null;
            event(new Registered($this->user));
        }
        $this->updateUser();
        $this->updateUserLastActivityDate();

        return $this->user;
    }

    private function updateUser(): void
    {
        $this->user->update([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }
}
