<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\GetTwoFactorAuthenticationSettings;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetTwoFactorAuthenticationSettingsTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_generates_the_2fa_codes(): void
    {
        $user = User::factory()->create();
        $user->two_factor_secret = encrypt('secret');
        $user->save();

        $array = (new GetTwoFactorAuthenticationSettings(
            user: $user,
        ))->execute();

        $this->assertArrayHasKey(
            'svg_qr_code',
            $array
        );
    }
}
