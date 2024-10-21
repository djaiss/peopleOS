<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\DisableTwoFactorAuthentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DisableTwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_disables_two_factor_authentication_for_a_user(): void
    {
        $user = User::factory()->create([
            'two_factor_secret' => 'secret',
            'two_factor_recovery_codes' => json_encode(['code1', 'code2']),
        ]);

        (new DisableTwoFactorAuthentication($user))->execute();

        $this->assertNull($user->fresh()->two_factor_secret);
        $this->assertNull($user->fresh()->two_factor_recovery_codes);
    }
}
