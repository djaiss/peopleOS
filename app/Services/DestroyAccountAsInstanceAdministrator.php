<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Account;
use App\Models\User;
use Exception;

class DestroyAccountAsInstanceAdministrator
{
    public function __construct(
        private readonly User $user,
        private readonly Account $account,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->account->delete();
    }

    private function validate(): void
    {
        if (! $this->user->is_instance_admin) {
            throw new Exception('Account is not an instance administrator');
        }
    }
}
