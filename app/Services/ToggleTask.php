<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ToggleTask
{
    public function __construct(
        private readonly User $user,
        private readonly Task $task,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $taskName = $this->task->name;

        $status = $this->task->is_completed;

        $this->task->update([
            'is_completed' => ! $status,
            'completed_at' => $status ? null : now(),
        ]);

        $this->updateUserLastActivityDate();
        $this->logUserAction($taskName);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->task->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(string $taskName): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'task_toggle',
            description: 'Toggled a task called '.$taskName,
        )->onQueue('low');
    }
}
