<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UpdateUserPassword
{
    public function __construct(
        public User $user,
        public string $currentPassword,
        public string $newPassword,
    ) {}

    /**
     * Update the user password.
     */
    public function execute(): User
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->user;
    }

    private function validate(): void
    {
        if (! Hash::check($this->currentPassword, $this->user->password)) {
            throw new Exception('Current password is incorrect');
        }
    }

    private function update(): void
    {
        $this->user->update([
            'password' => Hash::make($this->newPassword),
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'update_user_password',
            description: 'Updated their password',
        )->onQueue('low');
    }
}
