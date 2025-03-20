<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\TaskCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyTaskCategory
{
    public function __construct(
        private readonly User $user,
        private readonly TaskCategory $taskCategory,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $taskCategoryName = $this->taskCategory->name;

        $this->taskCategory->delete();

        $this->updateUserLastActivityDate();
        $this->logUserAction($taskCategoryName);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->taskCategory->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(string $taskCategoryName): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'task_category_deletion',
            description: 'Deleted the task category called '.$taskCategoryName,
        );
    }
}
