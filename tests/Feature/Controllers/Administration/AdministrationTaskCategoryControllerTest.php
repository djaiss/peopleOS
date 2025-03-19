<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\TaskCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationTaskCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_task_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/personalization/task-categories/new');

        $response->assertStatus(200);
        $response->assertViewIs('administration.personalization.partials.task-category-new');

        $response = $this->actingAs($user)
            ->from('/administration/personalization/task-categories/new')
            ->post('/administration/personalization/task-categories', [
                'name' => 'Email',
                'color' => 'bg-blue-500',
            ]);

        $response->assertRedirect('/administration/personalization');
        $response->assertSessionHas('status', __('Task category created'));

        $this->assertDatabaseHas('task_categories', [
            'account_id' => $user->account_id,
        ]);

        $this->assertEquals('Email', TaskCategory::latest()->first()->name);
        $this->assertEquals('bg-blue-500', TaskCategory::latest()->first()->color);

        $response = $this->actingAs($user)
            ->get('/administration/personalization');

        $response->assertSee('Email');
    }

    #[Test]
    public function it_can_edit_a_task_category(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Email',
            'color' => 'bg-blue-500',
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/personalization/task-categories/'.$taskCategory->id.'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('administration.personalization.partials.task-category-edit');
        $response->assertViewHas('taskCategory', $taskCategory);

        $response = $this->actingAs($user)
            ->from('/administration/personalization/task-categories/'.$taskCategory->id.'/edit')
            ->put('/administration/personalization/task-categories/'.$taskCategory->id, [
                'name' => 'Email',
                'color' => 'bg-blue-500',
            ]);

        $response->assertRedirect('/administration/personalization');
        $response->assertSessionHas('status', __('Task category updated'));

        $this->assertDatabaseHas('task_categories', [
            'id' => $taskCategory->id,
        ]);

        $this->assertEquals('Email', $taskCategory->refresh()->name);
        $this->assertEquals('bg-blue-500', $taskCategory->refresh()->color);

        $response = $this->actingAs($user)
            ->get('/administration/personalization');

        $response->assertSee('Email');
    }

    #[Test]
    public function it_cant_edit_a_task_category_from_another_account(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/personalization/task-categories/' . $taskCategory->id . '/edit');

        $response->assertStatus(404);
    }

    #[Test]
    public function it_can_delete_a_task_category(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->from('/administration/personalization')
            ->delete('/administration/personalization/task-categories/'.$taskCategory->id);

        $response->assertRedirect('/administration/personalization');
        $response->assertSessionHas('status', __('Task category deleted'));

        $this->assertDatabaseMissing('task_categories', [
            'id' => $taskCategory->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/personalization');

        $response->assertDontSee('Email');
    }

    #[Test]
    public function it_cant_delete_a_task_category_from_another_account(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create();

        $response = $this->actingAs($user)
            ->from('/administration/personalization')
            ->delete('/administration/personalization/task-categories/'.$taskCategory->id);

        $response->assertStatus(404);
    }
}
