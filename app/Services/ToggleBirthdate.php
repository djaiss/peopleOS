<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;

class ToggleBirthdate
{
    public function __construct(
        public User $user,
    ) {}

    /**
     * This setting is used to toggle the display of the birthdate in the UI.
     * If set to false, only the day and month will be displayed.
     * Other users will not be able to see the birthdate, therefore know
     * the age of the user.
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
            'does_display_age' => ! $this->user->does_display_age,
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
            action: 'display_age_toggle',
            description: 'Toggled display of age',
        );
    }
}
