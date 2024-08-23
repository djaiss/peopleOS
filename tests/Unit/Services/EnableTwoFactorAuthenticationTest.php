<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\EnableTwoFactorAuthentication;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EnableTwoFactorAuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_generates_the_2fa_codes(): void
    {
        $user = User::factory()->create();

        $user = (new EnableTwoFactorAuthentication(
            user: $user,
        ))->execute();

        $this->assertInstanceOf(
            User::class,
            $user
        );

        $this->assertNotNull(
            $user->two_factor_secret
        );
        $this->assertNotNull(
            $user->two_factor_recovery_codes
        );
    }
}
