<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\TaskCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationTaskCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $singleJsonStructure = [
        'data' => [
            'type',
            'id',
            'attributes' => [
                'name',
                'color',
                'created_at',
                'updated_at',
            ],
            'links' => ['self'],
        ],
    ];

    protected array $multipleJsonStructure = [
        'data' => [
            '*' => [
                'type',
                'id',
                'attributes' => [
                    'name',
                    'color',
                    'created_at',
                    'updated_at',
                ],
                'links' => ['self'],
            ],
        ],
    ];

    #[Test]
    public function it_can_list_the_task_categories_of_the_account(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Call',
            'color' => 'bg-blue-500',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/task-categories');

        $response->assertStatus(200);

        $response->assertJsonStructure($this->multipleJsonStructure);

        $data = $response->json('data');

        $this->assertEquals('task_category', $data[0]['type']);
        $this->assertEquals($taskCategory->id, $data[0]['id']);
        $this->assertEquals('Call', $data[0]['attributes']['name']);
        $this->assertEquals('bg-blue-500', $data[0]['attributes']['color']);
    }

    #[Test]
    public function it_can_create_a_task_category(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/task-categories', [
            'name' => 'Email',
            'color' => 'bg-blue-500',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('task_categories', [
            'account_id' => $user->account_id,
            'color' => 'bg-blue-500',
        ]);

        $response->assertJsonStructure($this->singleJsonStructure);

        $data = $response->json('data');

        $this->assertEquals('task_category', $data['type']);
        $this->assertEquals('Email', $data['attributes']['name']);
        $this->assertEquals('bg-blue-500', $data['attributes']['color']);
    }

    #[Test]
    public function it_can_update_a_task_category(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/task-categories/' . $taskCategory->id, [
            'name' => 'Email',
            'color' => 'bg-blue-500',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('task_categories', [
            'id' => $taskCategory->id,
            'color' => 'bg-blue-500',
        ]);

        $response->assertJsonStructure($this->singleJsonStructure);

        $data = $response->json('data');

        $this->assertEquals('task_category', $data['type']);
        $this->assertEquals('Email', $data['attributes']['name']);
        $this->assertEquals('bg-blue-500', $data['attributes']['color']);
    }

    #[Test]
    public function it_can_delete_a_task_category(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/administration/task-categories/' . $taskCategory->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('task_categories', [
            'id' => $taskCategory->id,
        ]);
    }
}
