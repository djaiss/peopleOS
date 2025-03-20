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

class UpdateTask
{
    public function __construct(
        private readonly User $user,
        private readonly Task $task,
        private readonly ?TaskCategory $taskCategory,
        private readonly ?Person $person,
        private readonly string $name,
        private readonly ?string $dueAt,
    ) {}

    public function execute(): Task
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->task->refresh();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->task->account_id) {
            throw new Exception('Task does not belong to the account');
        }

        if ($this->person && $this->user->account_id !== $this->person->account_id) {
            throw new Exception('Person does not belong to the account');
        }

        if ($this->taskCategory && $this->user->account_id !== $this->taskCategory->account_id) {
            throw new Exception('Task category does not belong to the account');
        }
    }

    private function update(): void
    {
        $this->task->update([
            'name' => $this->name,
            'due_at' => $this->dueAt ?? null,
            'person_id' => $this->person?->id,
            'task_category_id' => $this->taskCategory?->id,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'task_update',
            description: 'Updated the task called '.$this->task->name,
        );
    }
}
