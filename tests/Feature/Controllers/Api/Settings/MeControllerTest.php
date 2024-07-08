<?php

namespace Tests\Feature\Controllers\Api\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
                'email' => 'dwight.schrute@dundermifflin.com',
            ]
        );
    }
}
