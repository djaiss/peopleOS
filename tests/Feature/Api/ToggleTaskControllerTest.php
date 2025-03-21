<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ToggleTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_toggle_a_task(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-20'));

        $user = User::factory()->create();
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
            'is_completed' => false,
            'name' => 'Send wishes',
        ]);
        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/tasks/'.$task->id.'/toggle');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $task->id,
                'object' => 'task',
                'name' => 'Send wishes',
                'is_completed' => true,
                'due_at' => null,
                'completed_at' => 1742428800,
                'task_category' => null,
                'created_at' => 1742428800,
                'updated_at' => 1742428800,
            ],
        ]);
    }
}
