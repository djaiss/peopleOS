<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\TaskCategory;
use App\Models\User;
use App\Services\CreateTaskCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateTaskCategoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_task_category(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $taskCategory = (new CreateTaskCategory(
            user: $user,
            name: 'Birthday',
            color: 'bg-purple-100',
        ))->execute();

        $this->assertDatabaseHas('task_categories', [
            'id' => $taskCategory->id,
            'account_id' => $user->account_id,
            'color' => 'bg-purple-100',
        ]);

        $this->assertEquals('Birthday', $taskCategory->name);

        $this->assertInstanceOf(
            TaskCategory::class,
            $taskCategory
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'task_category_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created the task category called Birthday';
            }
        );
    }
}
