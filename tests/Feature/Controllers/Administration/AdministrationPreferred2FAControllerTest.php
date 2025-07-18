<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationPreferred2FAControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;

    #[Test]
    public function it_should_update_preferred_2fa_method(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-07-17 10:00:00'));

        $this->user = User::factory()->create([
            'two_factor_preferred_method' => 'email',
        ]);

        $response = $this->actingAs($this->user)
            ->from('/administration/security')
            ->put('/administration/security/2fa', [
                'method' => 'authenticator_app',
            ]);

        $response->assertRedirect('/administration/security');
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertEquals(
            'authenticator_app',
            $this->user->fresh()->two_factor_preferred_method,
        );
    }
}
