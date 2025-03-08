<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationApiControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_get_list_of_their_api_keys(): void
    {
        $user = User::factory()->create();

        // Create API tokens for the user
        $token1 = $user->createToken('Test API Key 1');
        $token2 = $user->createToken('Test API Key 2');

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/api');

        // Check that the response contains the user's API keys
        $response->assertJsonCount(2, 'data');

        // Check that the response contains the expected API key data
        $response->assertJsonFragment([
            'id' => $token1->accessToken->id,
            'name' => 'Test API Key 1',
        ]);

        $response->assertJsonFragment([
            'id' => $token2->accessToken->id,
            'name' => 'Test API Key 2',
        ]);
    }

    #[Test]
    public function user_can_create_a_new_api_key(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/api', [
            'label' => 'New API Key',
        ]);

        $response->assertStatus(200);

        // Check that the API key was created in the database
        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'New API Key',
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);

        // Check that the response contains the expected API key data
        $response->assertJsonStructure([
            'id',
            'object',
            'token',
            'name',
            'last_used_at',
            'created_at',
            'updated_at',
        ]);

        $response->assertJson([
            'object' => 'api_key',
            'name' => 'New API Key',
        ]);

        // Verify the token is a valid string
        $this->assertIsString($response->json('token'));
        $this->assertNotEmpty($response->json('token'));
    }

    #[Test]
    public function creating_api_key_requires_label(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/api', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['label']);
    }

    #[Test]
    public function unauthenticated_user_cannot_access_api_keys(): void
    {
        $response = $this->json('GET', '/api/administration/api');

        $response->assertStatus(401);
    }

    #[Test]
    public function unauthenticated_user_cannot_create_api_key(): void
    {
        $response = $this->json('POST', '/api/administration/api', [
            'label' => 'New API Key',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function user_can_delete_their_api_key(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test API Key');
        $tokenId = $token->accessToken->id;

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', "/api/administration/api/{$tokenId}");

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'API key deleted',
        ]);

        // Verify the token was deleted from the database
        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);
    }

    #[Test]
    public function user_cannot_delete_nonexistent_api_key(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/administration/api/999');

        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'API key not found',
        ]);
    }

    #[Test]
    public function user_cannot_delete_another_users_api_key(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $token = $user2->createToken('Other User API Key');
        $tokenId = $token->accessToken->id;

        Sanctum::actingAs($user1);

        $response = $this->json('DELETE', "/api/administration/api/{$tokenId}");

        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'API key not found',
        ]);

        // Verify the token still exists in the database
        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => $tokenId,
        ]);
    }

    #[Test]
    public function unauthenticated_user_cannot_delete_api_key(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test API Key');
        $tokenId = $token->accessToken->id;

        $response = $this->json('DELETE', "/api/administration/api/{$tokenId}");

        $response->assertStatus(401);

        // Verify the token still exists in the database
        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => $tokenId,
        ]);
    }
}
