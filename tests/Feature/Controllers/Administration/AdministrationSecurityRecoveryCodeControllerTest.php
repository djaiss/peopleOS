<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationSecurityRecoveryCodeControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_the_recovery_codes(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'two_factor_recovery_codes' => ['code1', 'code2', 'code3'],
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/security/recoveryCodes');

        $response->assertStatus(200);
        $this->assertArrayHasKey('recoveryCodes', $response);
    }
}
