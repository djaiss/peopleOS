<?php

namespace App\Services;

use App\Models\User;

class DisableTwoFactorAuthentication
{
    public function __construct(
        public User $user,
    ) {
    }

    public function execute(): User
    {
        $this->disable();

        return $this->user;
    }

    private function disable(): void
    {
        $this->user->two_factor_secret = null;
        $this->user->two_factor_recovery_codes = null;
        $this->user->two_factor_confirmed_at = null;

        $this->user->save();
    }
}
