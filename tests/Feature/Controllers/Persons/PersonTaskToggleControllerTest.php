<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonTaskToggleControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_toggle_task_completion(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'is_completed' => false,
        ]);

        $response = $this->actingAs($user)
            ->put(route('person.task.toggle', [
                'slug' => $person->slug,
                'task' => $task->id,
            ]));

        $response->assertRedirect(route('person.reminder.index', $person->slug));
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);
    }

    #[Test]
    public function user_can_untoggle_completed_task(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'is_completed' => true,
        ]);

        $response = $this->actingAs($user)
            ->put(route('person.task.toggle', [
                'slug' => $person->slug,
                'task' => $task->id,
            ]));

        $response->assertRedirect(route('person.reminder.index', $person->slug));
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => false,
        ]);
    }

    #[Test]
    public function user_cannot_toggle_task_belonging_to_another_user(): void
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $anotherUser->account_id,
        ]);
        $task = Task::factory()->create([
            'account_id' => $anotherUser->account_id,
            'person_id' => $person->id,
            'is_completed' => false,
        ]);

        $response = $this->actingAs($user)
            ->put(route('person.task.toggle', [
                'slug' => $person->slug,
                'task' => $task->id,
            ]));

        $response->assertStatus(401);
    }
}
