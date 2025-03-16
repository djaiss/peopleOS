<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;

class UpdateTimezone
{
    public function __construct(
        public User $user,
        public string $timezone,
    ) {}

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
            'timezone' => $this->timezone,
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
            action: 'timezone_update',
            description: 'Updated their timezone',
        );
    }
}
