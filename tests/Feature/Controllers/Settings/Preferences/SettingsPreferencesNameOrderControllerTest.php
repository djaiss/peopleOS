<?php

namespace Tests\Feature\Controllers\Settings\Preferences;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SettingsPreferencesNameOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_lets_the_user_edit_contact_name_order(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put('/settings/preferences/name', [
                'name-order' => '%nickname%',
            ])
            ->assertSee('007');
    }
}
