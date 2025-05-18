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

    #[Test]
    public function user_can_get_list_of_task_categories(): void
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
        $response->assertJsonFragment([
            'id' => $taskCategory->id,
            'name' => 'Call',
            'color' => 'bg-blue-500',
        ]);
    }

    #[Test]
    public function user_can_create_a_task_category(): void
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

        $this->assertEquals('Email', $response->json('data.name'));
    }

    #[Test]
    public function user_can_update_a_task_category(): void
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

        $this->assertEquals('Email', $response->json('data.name'));
    }

    #[Test]
    public function user_cannot_update_task_category_from_another_account(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/task-categories/' . $taskCategory->id, [
            'name' => 'Email',
            'color' => 'bg-blue-500',
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_task_category(): void
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

    #[Test]
    public function user_cannot_delete_task_category_from_another_account(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/administration/task-categories/' . $taskCategory->id);

        $response->assertStatus(404);
    }
}
