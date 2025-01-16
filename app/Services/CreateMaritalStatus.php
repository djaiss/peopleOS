<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MaritalStatus;
use App\Models\User;

class CreateMaritalStatus
{
    public function __construct(
        private readonly User $user,
        private readonly string $name,
    ) {}

    public function execute(): MaritalStatus
    {
        $position = MaritalStatus::where('account_id', $this->user->account_id)
            ->max('position') + 1;

        $maritalStatus = MaritalStatus::create([
            'account_id' => $this->user->account_id,
            'name' => $this->name,
            'position' => $position,
        ]);

        $this->updateUserLastActivityDate();
        $this->logUserAction($maritalStatus);

        return $maritalStatus;
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(MaritalStatus $maritalStatus): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'marital_status_creation',
            description: 'Created the marital status called '.$maritalStatus->name,
        );
    }
}
