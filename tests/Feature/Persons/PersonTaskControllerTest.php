<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_the_task_creation_form(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('person.task.new', $person->slug));

        $response->assertStatus(200);
        $response->assertViewIs('persons.reminders.partials.task-add');
        $response->assertViewHas('person', $person);
        $response->assertViewHas('taskCategories');
    }

    #[Test]
    public function it_creates_a_task(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('person.task.create', $person->slug), [
                'name' => 'Call mom',
                'due_at' => '2024-03-15',
                'task_category_id' => $taskCategory->id,
                'has_due_date' => true,
                'has_category' => true,
            ]);

        $response->assertRedirect(route('person.reminder.index', $person->slug));
        $response->assertSessionHas('status', trans('The task has been created'));
    }

    #[Test]
    public function it_creates_a_task_without_due_date_and_category(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('person.task.create', $person->slug), [
                'name' => 'Call mom',
                'due_at' => '2024-03-15',
            ]);

        $response->assertRedirect(route('person.reminder.index', $person->slug));
        $response->assertSessionHas('status', trans('The task has been created'));
    }

    #[Test]
    public function it_can_see_the_task_edit_form(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $task = Task::factory()->create([
            'person_id' => $person->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('person.task.edit', [
                'slug' => $person->slug,
                'task' => $task->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewIs('persons.reminders.partials.task-edit');
        $response->assertViewHas('task', $task);
        $response->assertViewHas('person', $person);
        $response->assertViewHas('taskCategories');
    }

    #[Test]
    public function it_can_update_a_task(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'name' => 'Original task',
        ]);

        $response = $this->actingAs($user)
            ->put(route('person.task.update', [
                'slug' => $person->slug,
                'task' => $task->id,
            ]), [
                'name' => 'Updated task name',
                'due_at' => '2024-03-16',
                'task_category_id' => $taskCategory->id,
                'has_due_date' => true,
                'has_category' => true,
            ]);

        $response->assertRedirect(route('person.reminder.index', $person->slug));
        $response->assertSessionHas('status', trans('The task has been updated'));
    }

    #[Test]
    public function user_can_update_a_task_removing_due_date_and_category(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'name' => 'Original task',
            'due_at' => '2024-03-15',
            'task_category_id' => $taskCategory->id,
        ]);

        $response = $this->actingAs($user)
            ->put(route('person.task.update', [
                'slug' => $person->slug,
                'task' => $task->id,
            ]), [
                'name' => 'Updated task name',
                'due_at' => '2024-03-16',
                'task_category_id' => $taskCategory->id,
            ]);

        $response->assertRedirect(route('person.reminder.index', $person->slug));
        $response->assertSessionHas('status', trans('The task has been updated'));
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

        $response = $this->actingAs($user)
            ->delete(route('person.task.destroy', [
                'slug' => $person->slug,
                'task' => $task->id,
            ]));

        $response->assertRedirect(route('person.reminder.index', $person->slug));
        $response->assertSessionHas('status', __('Task deleted'));

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
