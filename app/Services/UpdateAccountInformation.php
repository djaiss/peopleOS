<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Permission;
use App\Exceptions\PermissionException;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;

class UpdateAccountInformation
{
    public function __construct(
        public User $user,
        public string $name,
    ) {}

    /**
     * Update the account information.
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
        if ($this->user->permission !== Permission::ADMINISTRATOR->value) {
            throw new PermissionException('You are not authorized to update the account information.');
        }
    }

    private function update(): void
    {
        $this->user->account->update([
            'name' => $this->name,
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
            action: 'account_update',
            description: 'Updated their organization account',
        );
    }
}
