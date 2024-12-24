<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class EnableTwoFactorAuthentication
{
    public function __construct(
        public User $user,
    ) {
    }

    public function execute(): User
    {
        $this->enable();

        return $this->user;
    }

    private function enable(): void
    {
        $google2fa = app(Google2FA::class);

        $this->user->two_factor_secret = encrypt($google2fa->generateSecretKey());
        $this->user->two_factor_recovery_codes = encrypt(json_encode(Collection::times(8, function () {
            return Str::random(10) . '-' . Str::random(10);
        })->all()));

        $this->user->save();
    }
}
