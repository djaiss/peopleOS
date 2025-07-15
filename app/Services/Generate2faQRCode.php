<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use PragmaRX\Google2FALaravel\Google2FA;

/**
 * Generate a QR code for 2FA setup.
 */
class Generate2faQRCode
{
    private string $secret;

    private string $qrCodeSvg;

    public function __construct(
        private readonly User $user,
    ) {}

    public function execute(): array
    {
        $this->generateSecret();
        $this->generateQRCode();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return [
            'secret' => $this->secret,
            'qrCodeSvg' => $this->qrCodeSvg,
        ];
    }

    private function generateSecret(): void
    {
        $google2fa = new Google2FA(request());

        $this->secret = $google2fa->generateSecretKey();
        $this->user->update(['two_factor_secret' => $this->secret]);
    }

    private function generateQRCode(): void
    {
        $google2fa = new Google2FA(request());

        $this->qrCodeSvg = $google2fa->getQRCodeInline(
            company: config('app.name'),
            holder: $this->user->email,
            secret: $this->secret,
            size: 120,
        );
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: '2fa_qr_code_generation',
            description: 'Generated 2FA QR code for setup',
        )->onQueue('low');
    }
}
