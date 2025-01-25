<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Models\WorkHistory;
use Exception;

class DestroyWorkHistory
{
    public function __construct(
        private readonly User $user,
        private readonly WorkHistory $workHistory,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $this->workHistory->delete();

        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->workHistory->person->account_id) {
            throw new Exception('User and work history are not in the same account');
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
            action: 'work_history_deletion',
            description: 'Deleted a work history entry for '.$this->workHistory->person->name,
        );
    }
}
