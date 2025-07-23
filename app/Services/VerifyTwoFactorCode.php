<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

/**
 * Service to verify a user's 2FA code (TOTP or rescue code).
 */
class VerifyTwoFactorCode
{
    public function __construct(
        private readonly User $user,
        private readonly string $code,
    ) {}

    /**
     * Execute the verification of the 2FA code.
     *
     * @return bool True if the code is valid, false otherwise
     */
    public function execute(): bool
    {
        if ($this->verifyTotp()) {
            return true;
        }
        return $this->verifyRescueCode();
    }

    private function verifyTotp(): bool
    {
        if (!$this->user->two_factor_secret) {
            return false;
        }

        $secret = $this->user->two_factor_secret;
        $google2fa = new Google2FA();
        return $google2fa->verifyKey($secret, $this->code);
    }

    private function verifyRescueCode(): bool
    {
        if (!is_array($this->user->two_factor_recovery_codes)) {
            return false;
        }

        $codes = $this->user->two_factor_recovery_codes;
        if (in_array($this->code, $codes, true)) {
            $this->user->two_factor_recovery_codes = array_values(array_diff($codes, [$this->code]));
            $this->user->save();
            return true;
        }

        return false;
    }
}
