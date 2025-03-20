<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\TaskCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateTaskCategory
{
    public function __construct(
        private readonly User $user,
        private readonly TaskCategory $taskCategory,
        private readonly string $name,
        private readonly string $color,
    ) {}

    public function execute(): TaskCategory
    {
        $this->validate();

        $this->taskCategory->update([
            'name' => $this->name,
            'color' => $this->color,
        ]);

        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->taskCategory;
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

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'task_category_update',
            description: 'Updated the task category called '.$this->taskCategory->name,
        );
    }
}
