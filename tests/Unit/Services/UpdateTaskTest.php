<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use App\Services\UpdateTask;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_task(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $task = (new UpdateTask(
            user: $user,
            task: $task,
            person: $person,
            taskCategory: $taskCategory,
            name: 'Birthday',
            dueAt: '2025-03-20',
        ))->execute();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'task_category_id' => $taskCategory->id,
            'due_at' => '2025-03-20 00:00:00',
        ]);

        $this->assertEquals('Birthday', $task->name);

        $this->assertInstanceOf(
            Task::class,
            $task
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
                return $job->action === 'task_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated the task called Birthday';
            }
        );
    }

    #[Test]
    public function it_updates_a_task_with_as_few_parameters_as_possible(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $task = (new UpdateTask(
            user: $user,
            task: $task,
            person: null,
            taskCategory: null,
            name: 'Birthday',
            dueAt: null,
        ))->execute();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'account_id' => $user->account_id,
            'person_id' => null,
            'task_category_id' => null,
            'due_at' => null,
        ]);

        $this->assertEquals('Birthday', $task->name);
    }

    #[Test]
    public function it_does_not_update_a_task_if_the_task_does_not_belong_to_the_account(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Task does not belong to the account');

        $user = User::factory()->create();
        $task = Task::factory()->create();

        (new UpdateTask(
            user: $user,
            task: $task,
            person: null,
            taskCategory: null,
            name: 'Birthday',
            dueAt: null,
        ))->execute();
    }

    #[Test]
    public function it_does_not_update_a_task_if_the_person_does_not_belong_to_the_account(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Person does not belong to the account');

        $user = User::factory()->create();
        $person = Person::factory()->create();
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
        ]);

        (new UpdateTask(
            user: $user,
            task: $task,
            person: $person,
            taskCategory: null,
            name: 'Birthday',
            dueAt: null,
        ))->execute();
    }

    #[Test]
    public function it_does_not_update_a_task_if_the_task_category_does_not_belong_to_the_account(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Task category does not belong to the account');

        $user = User::factory()->create();
        $taskCategory = TaskCategory::factory()->create();
        $task = Task::factory()->create([
            'account_id' => $user->account_id,
        ]);

        (new UpdateTask(
            user: $user,
            task: $task,
            person: null,
            taskCategory: $taskCategory,
            name: 'Birthday',
            dueAt: null,
        ))->execute();
    }
}
