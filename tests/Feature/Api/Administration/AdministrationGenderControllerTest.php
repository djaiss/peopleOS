<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\Gender;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationGenderControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $collectionJsonStructure = [
        'data' => [
            '*' => [
                'type',
                'id',
                'attributes' => [
                    'name',
                    'position',
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
                'position',
                'created_at',
                'updated_at',
            ],
            'links' => [
                'self',
            ],
        ],
    ];

    #[Test]
    public function it_can_list_the_genders_of_the_account(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
            'position' => 1,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/genders');

        $response->assertStatus(200);

        $response->assertJsonStructure($this->collectionJsonStructure);

        $response->assertJsonCount(1, 'data');

        $firstItem = $response->json('data.0');

        $this->assertEquals('gender', $firstItem['type']);
        $this->assertEquals($gender->id, $firstItem['id']);
        $this->assertEquals('Male', $firstItem['attributes']['name']);
        $this->assertEquals(1, $firstItem['attributes']['position']);
    }

    #[Test]
    public function it_can_create_a_gender(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/genders', [
            'name' => 'Female',
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure($this->singleJsonStructure);

        $this->assertDatabaseHas('genders', [
            'account_id' => $user->account_id,
            'position' => 1,
        ]);

        $data = $response->json('data');

        $this->assertEquals('gender', $data['type']);
        $this->assertEquals('Female', $data['attributes']['name']);
        $this->assertEquals(1, $data['attributes']['position']);
    }

    #[Test]
    public function it_can_show_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
            'position' => 1,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/genders/' . $gender->id);

        $response->assertStatus(200);

        $response->assertJsonStructure($this->singleJsonStructure);

        $data = $response->json('data');

        $this->assertEquals('gender', $data['type']);
        $this->assertEquals('Male', $data['attributes']['name']);
        $this->assertEquals(1, $data['attributes']['position']);
    }

    #[Test]
    public function user_can_update_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/genders/' . $gender->id, [
            'name' => 'Non-binary',
            'position' => 3,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure($this->singleJsonStructure);
        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
            'position' => 3,
        ]);

        $data = $response->json('data');

        $this->assertEquals('Non-binary', $data['attributes']['name']);
        $this->assertEquals(3, $data['attributes']['position']);
    }

    #[Test]
    public function user_can_delete_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/administration/genders/' . $gender->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('genders', [
            'id' => $gender->id,
        ]);
    }
}
