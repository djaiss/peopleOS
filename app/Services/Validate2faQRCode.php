<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use Illuminate\Support\Str;
use PragmaRX\Google2FALaravel\Google2FA;

/**
 * Validate the code from the QR code for 2FA setup.
 */
class Validate2faQRCode
{
    private string $secret;

    private string $qrCodeSvg;

    public function __construct(
        private readonly User $user,
        private readonly string $token,
    ) {}

    public function execute(): void
    {
        $this->validateToken();
        $this->generateRecoveryCodes();
        $this->updateUserLastActivityDate();
    }

    private function validateToken(): void
    {
        $google2fa = new Google2FA(request());

        if (!$google2fa->verifyKey($this->user->two_factor_secret, (string) $this->token)) {
            throw new \InvalidArgumentException(__('The provided token is invalid.'));
        }

        $this->user->update(['two_factor_confirmed_at' => now()]);
    }

    private function generateRecoveryCodes(): void
    {
        $this->user->update(['two_factor_recovery_codes' => $this->generateRandomCodes()]);
    }

    private function generateRandomCodes(): array
    {
        return collect()->times(8)->map(fn () => Str::random(10))->all();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }
}
