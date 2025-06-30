<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_logs_in_a_user(): void
    {
        $user = User::factory()->create([
            'email' => 'rachel.green@friends.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => 'rachel.green@friends.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'status',
            'data' => [
                'token',
            ],
        ]);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData['data']['token']);
    }

    #[Test]
    public function it_logs_out_a_user(): void
    {
        $user = User::factory()->create([
            'email' => 'rachel.green@friends.com',
            'password' => bcrypt('password'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/logout');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'status',
        ]);

        $responseData = $response->json();
        $this->assertEquals('Logged out successfully', $responseData['message']);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }
}
