<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Task;
use App\Models\User;
use App\Services\ToggleTask;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ToggleTaskTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_toggles_a_task(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-20'));
        Queue::fake();

        $user = User::factory()->create();
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
            'is_completed' => false,
            'name' => 'Birthday',
        ]);

        (new ToggleTask(
            user: $user,
            task: $task,
        ))->execute();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
            'completed_at' => '2025-03-20 00:00:00',
        ]);

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
                return $job->action === 'task_toggle'
                    && $job->user->id === $user->id
                    && $job->description === 'Toggled a task called Birthday';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new ToggleTask(
            user: $user,
            task: $task,
        ))->execute();
    }
}
