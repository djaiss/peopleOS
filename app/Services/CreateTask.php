<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use Exception;

class CreateTask
{
    private Task $task;

    public function __construct(
        private readonly User $user,
        private readonly ?Person $person,
        private readonly ?TaskCategory $taskCategory,
        private readonly string $name,
        private readonly ?string $dueAt,
    ) {}

    public function execute(): Task
    {
        $this->validate();
        $this->create();
        $this->updateUserLastActivityDate();
        $this->logUserAction($this->task);

        return $this->task;
    }

    private function validate(): void
    {
        if ($this->person && $this->user->account_id !== $this->person->account_id) {
            throw new Exception('Person does not belong to the account');
        }

        if ($this->taskCategory && $this->user->account_id !== $this->taskCategory->account_id) {
            throw new Exception('Task category does not belong to the account');
        }
    }

    private function create(): void
    {
        $this->task = Task::create([
            'account_id' => $this->user->account_id,
            'person_id' => $this->person?->id,
            'task_category_id' => $this->taskCategory?->id,
            'name' => $this->name,
            'due_at' => $this->dueAt ?? null,
            'is_completed' => false,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(Task $task): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'task_creation',
            description: 'Created the task called '.$task->name,
        );
    }
}
