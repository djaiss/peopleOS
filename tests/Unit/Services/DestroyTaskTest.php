<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Task;
use App\Models\User;
use App\Services\DestroyTask;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyTaskTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_task(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Birthday',
        ]);

        (new DestroyTask(
            user: $user,
            task: $task,
        ))->execute();

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
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
            job: UpdatePersonLastConsultedDate::class,
            callback: function (UpdatePersonLastConsultedDate $job) use ($person): bool {
                return $job->person->id === $person->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'task_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted a task called Birthday';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyTask(
            user: $user,
            task: $task,
        ))->execute();
    }
}
