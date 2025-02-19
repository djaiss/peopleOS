<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\PersonSeenReport;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyPersonSeenReport
{
    public function __construct(
        private readonly User $user,
        private readonly PersonSeenReport $personSeenReport,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->delete();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->personSeenReport->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function delete(): void
    {
        $this->personSeenReport->delete();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'person_seen_report_deletion',
            description: 'Deleted having seen '.$this->personSeenReport->person->name,
        );
    }
}
