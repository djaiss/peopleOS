<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyMaritalStatus
{
    public function __construct(
        private readonly User $user,
        private readonly MaritalStatus $maritalStatus,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $maritalStatusName = $this->maritalStatus->name;

        $this->maritalStatus->delete();

        $this->updateUserLastActivityDate();
        $this->logUserAction($maritalStatusName);
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

    private function logUserAction(string $maritalStatusName): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'marital_status_deletion',
            description: 'Deleted the marital status called '.$maritalStatusName,
        );
    }
}
