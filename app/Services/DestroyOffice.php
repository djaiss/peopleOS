<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Permission;
use App\Exceptions\PermissionException;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Office;
use App\Models\User;

class DestroyOffice
{
    public function __construct(
        public User $user,
        public Office $office,
    ) {}

    /**
     * Destroy an office.
     * Only administrators can destroy an office.
     */
    public function execute(): void
    {
        $this->validate();
        $this->destroy();
        $this->updateUserLastActivityDate();
        $this->log();
    }

    private function validate(): void
    {
        if ($this->user->permission !== Permission::ADMINISTRATOR->value) {
            throw new PermissionException();
        }

        if ($this->office->account_id !== $this->user->account_id) {
            throw new PermissionException();
        }
    }

    private function destroy(): void
    {
        $this->office->delete();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'office_deletion',
            description: 'Deleted the office called '.$this->office->name,
        );
    }
}
