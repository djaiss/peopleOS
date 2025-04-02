<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\TaskCategory;
use App\Models\User;

class CreateTaskCategory
{
    public function __construct(
        private readonly User $user,
        private readonly string $name,
        private readonly string $color,
    ) {}

    public function execute(): TaskCategory
    {
        $taskCategory = TaskCategory::create([
            'account_id' => $this->user->account_id,
            'name' => $this->name,
            'color' => $this->color,
        ]);

        $this->updateUserLastActivityDate();
        $this->logUserAction($taskCategory);

        return $taskCategory;
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(TaskCategory $taskCategory): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'task_category_creation',
            description: 'Created the task category called '.$taskCategory->name,
        )->onQueue('low');
    }
}
