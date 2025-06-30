<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MeTimezoneControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_update_user_timezone(): void
    {
        $user = User::factory()->create(['timezone' => 'UTC']);
        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/me/timezone', [
            'timezone' => 'America/New_York',
        ]);

        $response->assertOk();

        $this->assertEquals(
            $response->json()['data'],
            [
                'type' => 'timezone',
                'attributes' => [
                    'timezone' => 'America/New_York',
                ],
                'links' => [
                    'self' => config('app.url') . '/api/me',
                ],
            ],
        );
    }

    #[Test]
    public function it_validates_timezone_input(): void
    {
        $user = User::factory()->create(['timezone' => 'UTC']);
        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/me/timezone', [
            'timezone' => 'Invalid_Timezone',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['timezone']);
    }

    #[Test]
    public function it_requires_authentication(): void
    {
        $response = $this->json('PUT', '/api/me/timezone', [
            'timezone' => 'Europe/London',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_can_get_current_user_timezone(): void
    {
        $user = User::factory()->create(['timezone' => 'Europe/Paris']);
        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/me/timezone');

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'type' => 'timezone',
                    'attributes' => [
                        'timezone' => 'Europe/Paris',
                    ],
                    'links' => [
                        'self' => config('app.url') . '/api/me',
                    ],
                ],
            ]);
    }
}
