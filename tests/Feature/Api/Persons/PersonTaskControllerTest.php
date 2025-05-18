<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Persons;

use App\Models\Person;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_a_task(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-20'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Personal',
            'color' => 'bg-blue-500',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/persons/' . $person->id . '/tasks', [
            'name' => 'Send wishes',
            'is_completed' => false,
            'due_at' => '2021-01-01',
            'task_category_id' => $taskCategory->id,
        ]);

        $response->assertStatus(201);

        $task = Task::where('person_id', $person->id)->first();
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'object' => 'task',
                'name' => 'Send wishes',
                'is_completed' => false,
                'due_at' => 1609459200,
                'completed_at' => null,
                'task_category' => [
                    'id' => $taskCategory->id,
                    'name' => 'Personal',
                    'color' => 'bg-blue-500',
                ],
                'created_at' => 1742428800,
                'updated_at' => 1742428800,
            ],
        ]);
    }

    #[Test]
    public function user_can_update_a_task(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-20'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'name' => 'Send wishes',
            'is_completed' => false,
        ]);
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Personal',
            'color' => 'bg-blue-500',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/' . $person->id . '/tasks/' . $task->id, [
            'name' => 'Unsend wishes',
            'due_at' => '2021-01-01',
            'task_category_id' => $taskCategory->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'object' => 'task',
                'name' => 'Unsend wishes',
                'is_completed' => false,
                'due_at' => 1609459200,
                'completed_at' => null,
                'task_category' => [
                    'id' => $taskCategory->id,
                    'name' => 'Personal',
                    'color' => 'bg-blue-500',
                ],
                'created_at' => 1742428800,
                'updated_at' => 1742428800,
            ],
        ]);
    }

    #[Test]
    public function user_can_delete_a_task(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/' . $person->id . '/tasks/' . $task->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    #[Test]
    public function user_can_get_a_task(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-20'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $task = Task::factory()->create([
            'person_id' => $person->id,
            'name' => 'Send wishes',
            'is_completed' => false,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/' . $person->id . '/tasks/' . $task->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'object' => 'task',
                'name' => 'Send wishes',
                'is_completed' => false,
                'due_at' => null,
                'completed_at' => null,
                'task_category' => null,
                'created_at' => 1742428800,
                'updated_at' => 1742428800,
            ],
        ]);
    }

    #[Test]
    public function user_cannot_get_task_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $task = Task::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/' . $person->id . '/tasks/' . $task->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_cannot_get_task_from_another_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $task = Task::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/' . $person->id . '/tasks/' . $task->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_get_list_of_tasks(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-20'));
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $task = Task::factory()->create([
            'person_id' => $person->id,
            'name' => 'Send wishes',
            'is_completed' => false,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/' . $person->id . '/tasks');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                0 => [
                    'id' => $task->id,
                    'object' => 'task',
                    'name' => 'Send wishes',
                    'is_completed' => false,
                    'due_at' => null,
                    'completed_at' => null,
                    'task_category' => null,
                    'created_at' => 1742428800,
                    'updated_at' => 1742428800,
                ],
            ],
        ]);
    }
}
