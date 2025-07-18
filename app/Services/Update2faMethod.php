<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;

class Update2faMethod
{
    public function __construct(
        private readonly User $user,
        private readonly string $preferredMethods,
    ) {}

    /**
     * Update the user's preferred 2FA method, log the action, and update the user's last activity date.
     */
    public function execute(): User
    {
        $this->update();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->user;
    }

    private function update(): void
    {
        $this->user->update([
            'two_factor_preferred_method' => $this->preferredMethods,
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
            action: 'update_preferred_method',
            description: 'Updated their preferred 2FA method',
        )->onQueue('low');
    }
}
