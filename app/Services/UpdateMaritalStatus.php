<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateMaritalStatus
{
    public function __construct(
        private readonly User $user,
        private readonly MaritalStatus $maritalStatus,
        private readonly string $name,
        private readonly int $position,
    ) {}

    public function execute(): MaritalStatus
    {
        $this->validate();

        $this->maritalStatus->update([
            'name' => $this->name,
            'position' => $this->position,
        ]);

        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->maritalStatus;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->maritalStatus->account_id) {
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
            action: 'marital_status_update',
            description: 'Updated the marital status called '.$this->maritalStatus->name,
        );
    }
}
