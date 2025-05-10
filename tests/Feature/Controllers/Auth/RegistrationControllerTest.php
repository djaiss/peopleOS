<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_renders_the_registration_screen(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    #[Test]
    public function it_registers_a_new_user(): void
    {
        config(['peopleos.show_marketing_site' => false]);
        config(['peopleos.enable_waitlist' => false]);

        $response = $this->post('/register', [
            'first_name' => 'Test User',
            'last_name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard.index', absolute: false));
    }

    #[Test]
    public function it_does_not_register_a_new_user_if_the_waitlist_is_enabled_and_the_user_is_not_on_the_waitlist(): void
    {
        config(['peopleos.show_marketing_site' => false]);
        config(['peopleos.enable_waitlist' => true]);
        config(['peopleos.enable_anti_spam' => false]);

        $response = $this->post('/register', [
            'first_name' => 'Test User',
            'last_name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email' => 'You are not part of the beta yet.']);
    }
}
