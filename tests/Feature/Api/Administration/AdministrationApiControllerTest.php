<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationApiControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $collectionJsonStructure = [
        'data' => [
            '*' => [
                'type',
                'id',
                'attributes' => [
                    'name',
                    'token',
                    'last_used_at',
                    'created_at',
                    'updated_at',
                ],
                'links' => [
                    'self',
                ],
            ],
        ],
    ];

    private array $singleJsonStructure = [
        'data' => [
            'type',
            'id',
            'attributes' => [
                'name',
                'token',
                'last_used_at',
                'created_at',
                'updated_at',
            ],
            'links' => [
                'self',
            ],
        ],
        'token',
    ];

    #[Test]
    public function it_can_list_the_api_keys_of_the_current_user(): void
    {
        Carbon::setTestNow('2025-07-01 00:00:00');
        $user = User::factory()->create();

        $token1 = $user->createToken('Test API Key 1');
        $token2AccessToken = $user->createToken('Test API Key 2')->accessToken;
        $token2AccessToken->last_used_at = Carbon::now()->subDays(5);
        $token2AccessToken->save();

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/api');

        $response->assertJsonStructure($this->collectionJsonStructure);

        $response->assertJsonCount(2, 'data');
    }

    #[Test]
    public function it_can_create_a_new_api_key(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/api', [
            'label' => 'New API Key',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'New API Key',
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);

        $response->assertJsonStructure($this->singleJsonStructure);
    }

    #[Test]
    public function user_can_delete_their_api_key(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test API Key');
        $tokenId = $token->accessToken->id;

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', "/api/administration/api/{$tokenId}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);
    }
}
