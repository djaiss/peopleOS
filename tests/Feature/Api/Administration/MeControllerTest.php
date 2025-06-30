<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MeControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_the_information_about_the_logged_user(): void
    {
        $user = Sanctum::actingAs(
            User::factory()->create([
                'first_name' => 'Dwight',
                'last_name' => 'Schrute',
                'email' => 'dwight.schrute@dundermifflin.com',
                'nickname' => 'Dwight',
                'born_at' => '1985-03-15',
            ]),
        );

        $response = $this->json('GET', '/api/me');

        $response->assertStatus(200);

        $this->assertEquals(
            $response->json()['data'],
            [
                'type' => 'user',
                'id' => (string) $user->id,
                'attributes' => [
                    'first_name' => 'Dwight',
                    'last_name' => 'Schrute',
                    'email' => 'dwight.schrute@dundermifflin.com',
                    'nickname' => 'Dwight',
                    'born_at' => 479692800,
                ],
                'links' => [
                    'self' => config('app.url') . '/api/me',
                ],
            ],
        );
    }

    #[Test]
    public function it_updates_the_profile(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
            'email' => 'dwight.schrute@dundermifflin.com',
            'nickname' => 'Dwight',
            'born_at' => '1985-03-15',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/me', [
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'email' => 'michael.scott@dundermifflin.com',
            'nickname' => 'Michael',
            'born_at' => '1985-03-15',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'type' => 'user',
                'id' => (string) $user->id,
                'attributes' => [
                    'first_name' => 'Michael',
                    'last_name' => 'Scott',
                    'email' => 'michael.scott@dundermifflin.com',
                    'nickname' => 'Michael',
                    'born_at' => 479692800,
                ],
                'links' => [
                    'self' => config('app.url') . '/api/me',
                ],
            ],
            $response->json()['data'],
        );
    }

    #[Test]
    public function it_updates_the_profile_and_triggers_a_new_address_email(): void
    {
        Event::fake();

        $user = User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
            'email' => 'dwight.schrute@dundermifflin.com',
            'nickname' => 'Dwight',
            'born_at' => '1985-03-15',
        ]);

        Sanctum::actingAs($user);

        $this->json('PUT', '/api/me', [
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'email' => 'michael.scott@dundermifflin.com',
            'nickname' => 'Michael',
            'born_at' => '1985-03-15',
        ]);

        Event::assertDispatched(Registered::class);
    }
}
