<?php

namespace Tests\Feature\Controllers\Settings;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
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

        $response = $this
            ->actingAs($user)
            ->put('/settings/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/settings/profile');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }
}
