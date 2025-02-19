<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\PersonSeenReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePersonSeenReport
{
    public function __construct(
        private readonly User $user,
        private readonly PersonSeenReport $personSeenReport,
        private readonly Carbon $seenAt,
        private readonly ?string $periodOfTime = null,
    ) {}

    public function execute(): PersonSeenReport
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->personSeenReport;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->personSeenReport->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->personSeenReport->update([
            'seen_at' => $this->seenAt,
            'period_of_time' => $this->periodOfTime ?? null,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'person_seen_report_update',
            description: 'Updated having seen '.$this->personSeenReport->person->name,
        );
    }
}
