<?php

namespace App\Services;

use App\Models\User;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use PragmaRX\Google2FA\Google2FA;

class GetTwoFactorAuthenticationSettings
{
    public function __construct(
        public User $user,
    ) {
    }

    public function execute(): array
    {
        return $this->getDetails();
    }

    private function getDetails(): array
    {
        return [
            'svg_qr_code' => $this->getSVGQRCode(),
            'recovery_codes' => json_decode(decrypt(
                $this->user->two_factor_recovery_codes
            )),
        ];
    }

    private function getSVGQRCode(): string
    {
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(140, 0, null, null, Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(45, 55, 72))),
                new SvgImageBackEnd
            )
        ))->writeString($this->twoFactorQrCodeUrl());

        return trim(substr($svg, strpos($svg, "\n") + 1));
    }

    private function twoFactorQrCodeUrl(): string
    {
        $this->user = (new EnableTwoFactorAuthentication(
            user: $this->user,
        ))->execute();

        return app(Google2FA::class)->getQRCodeUrl(
            config('app.name'),
            $this->user->first_name . ' ' . $this->user->last_name,
            decrypt($this->user->two_factor_secret)
        );
    }
}
