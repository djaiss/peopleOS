<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_the_change_password_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/security');

        $response->assertStatus(200);
        $response->assertViewIs('administration.security.index');
    }

    #[Test]
    public function it_allows_the_user_to_update_their_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/administration/security')
            ->put('/administration/password', [
                'current_password' => 'password',
                'new_password' => 'new-password',
                'new_password_confirmation' => 'new-password',
            ]);

        $response->assertRedirect('/administration/security');
        $response->assertSessionHas('status', 'Password updated successfully');

        $this->assertTrue(password_verify('new-password', $user->fresh()->password));
    }
}
