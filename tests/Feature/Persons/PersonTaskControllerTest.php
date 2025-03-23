<?php

declare(strict_types=1);

namespace Tests\Feature\Persons;

use App\Models\Person;
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
            ->get(route('persons.tasks.new', $person->slug));

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
            ->post(route('persons.tasks.create', $person->slug), [
                'name' => 'Call mom',
                'due_at' => '2024-03-15',
                'task_category_id' => $taskCategory->id,
                'has_due_date' => true,
                'has_category' => true,
            ]);

        $response->assertRedirect(route('persons.reminders.index', $person->slug));
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
            ->post(route('persons.tasks.create', $person->slug), [
                'name' => 'Call mom',
                'due_at' => '2024-03-15',
            ]);

        $response->assertRedirect(route('persons.reminders.index', $person->slug));
        $response->assertSessionHas('status', trans('The task has been created'));
    }
}
