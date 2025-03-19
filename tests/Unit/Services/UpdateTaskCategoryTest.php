<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\TaskCategory;
use App\Models\User;
use App\Services\UpdateTaskCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTaskCategoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_task_category(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Birthday',
            'color' => 'bg-purple-100',
        ]);

        $updatedTaskCategory = (new UpdateTaskCategory(
            user: $user,
            taskCategory: $taskCategory,
            name: 'Birthday',
            color: 'bg-purple-100',
        ))->execute();

        $this->assertDatabaseHas('task_categories', [
            'id' => $taskCategory->id,
            'account_id' => $user->account_id,
            'color' => 'bg-purple-100',
        ]);

        $this->assertEquals('Birthday', $updatedTaskCategory->name);

        $this->assertInstanceOf(
            TaskCategory::class,
            $updatedTaskCategory
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'task_category_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated the task category called Birthday';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateTaskCategory(
            user: $user,
            taskCategory: $taskCategory,
            name: 'Birthday',
            color: 'bg-purple-100',
        ))->execute();
    }
}
