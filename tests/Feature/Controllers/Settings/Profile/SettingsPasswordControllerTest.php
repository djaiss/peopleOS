<?php

namespace Tests\Feature\Controllers\Settings\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SettingsPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_lets_the_user_edit_his_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings/password')
            ->assertSee('Current password');

        $response = $this
            ->actingAs($user)
            ->put('/settings/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/settings/password');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    #[Test]
    public function it_requires_the_current_password_to_be_correct(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/settings/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertSessionHasErrors();
    }
}
