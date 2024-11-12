<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SettingsApiAccessControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_lets_the_user_manage_API_keys(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/settings/api', [
                'token_name' => 'Test key',
            ])
            ->assertRedirect('/settings/api');

        $this->actingAs($user)
            ->get('/settings/api')
            ->assertSee('Test key');

        $this->actingAs($user)
            ->delete('/settings/api/1')
            ->assertRedirect('/settings/api');
    }
}
