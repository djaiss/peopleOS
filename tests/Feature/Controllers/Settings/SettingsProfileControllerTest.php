<?php

namespace Tests\Feature\Controllers\Settings;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SettingsProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_lets_the_user_edit_his_profile(): void
    {
        $user = User::factory()->create([
            'first_name' => 'henri',
            'last_name' => 'troyat',
            'email' => 'henri@troyat.com',
        ]);

        $this->actingAs($user)
            ->get('/settings/profile')
            ->assertSee('henri');

        $this->actingAs($user)
            ->put('/settings/profile', [
                'first_name' => 'celine',
                'last_name' => 'troyat',
                'email' => 'henri@troyat.com',
            ])
            ->assertRedirectToRoute('settings.profile.index');

        $this->actingAs($user)
            ->get('/settings/profile')
            ->assertSee('celine');
    }

    #[Test]
    public function it_lets_the_user_edit_his_profile_and_triggers_a_new_address_email(): void
    {
        Event::fake();

        $user = User::factory()->create([
            'first_name' => 'henri',
            'last_name' => 'troyat',
            'email' => 'henri@troyat.com',
        ]);

        $this->actingAs($user)
            ->get('/settings/profile')
            ->assertSee('henri');

        $this->actingAs($user)
            ->put('/settings/profile', [
                'first_name' => 'celine',
                'last_name' => 'troyat',
                'email' => 'henri@dunder.com',
            ])
            ->assertRedirectToRoute('settings.profile.index');

        Event::assertDispatched(Registered::class);
    }
}
