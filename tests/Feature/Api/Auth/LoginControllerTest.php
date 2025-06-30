<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
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
}
