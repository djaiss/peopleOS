<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;

class ToggleDisplayFullNames
{
    public function __construct(
        public User $user,
    ) {}

    /**
     * Toggle the display of full names in the entire UI.
     */
    public function execute(): User
    {
        $this->toggle();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->user;
    }

    private function toggle(): void
    {
        $this->user->update([
            'does_display_full_names' => ! $this->user->does_display_full_names,
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
            action: 'display_full_names_toggle',
            description: 'Toggled display of full names',
        );
    }
}
