<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyTask
{
    public function __construct(
        private readonly User $user,
        private readonly Task $task,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $taskName = $this->task->name;

        $this->task->delete();

        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction($taskName);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->task->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->task->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(string $taskName): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'task_deletion',
            description: 'Deleted a task called '.$taskName,
        )->onQueue('low');
    }
}
