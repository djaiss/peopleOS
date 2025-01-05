<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Settings;

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
            ])
        );

        $response = $this->json('GET', '/api/me');

        $response->assertStatus(200);

        $this->assertEquals(
            $response->json(),
            [
                'id' => $user->id,
                'first_name' => 'Dwight',
                'last_name' => 'Schrute',
                'nickname' => 'Dwight',
                'email' => 'dwight.schrute@dundermifflin.com',
            ]
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
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/me', [
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'email' => 'michael.scott@dundermifflin.com',
            'nickname' => 'Michael',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $user->id,
                'first_name' => 'Michael',
                'last_name' => 'Scott',
                'email' => 'michael.scott@dundermifflin.com',
                'nickname' => 'Michael',
            ],
            $response->json()
        );

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'email' => 'michael.scott@dundermifflin.com',
            'nickname' => 'Michael',
        ]);
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
        ]);

        Sanctum::actingAs($user);

        $this->json('PUT', '/api/me', [
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'email' => 'michael.scott@dundermifflin.com',
            'nickname' => 'Michael',
        ]);

        Event::assertDispatched(Registered::class);
    }
}
