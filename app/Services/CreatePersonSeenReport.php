<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\PersonSeenReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreatePersonSeenReport
{
    private PersonSeenReport $personSeenReport;

    public function __construct(
        public User $user,
        public Person $person,
        public Carbon $seenAt,
        public ?string $periodOfTime = null,
    ) {}

    public function execute(): PersonSeenReport
    {
        $this->validate();
        $this->create();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->personSeenReport;
    }

    private function validate(): void
    {
        if ($this->person->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function create(): void
    {
        $this->personSeenReport = PersonSeenReport::create([
            'account_id' => $this->user->account_id,
            'person_id' => $this->person->id,
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
            action: 'person_seen_report_creation',
            description: 'Logged having seen '.$this->person->name,
        );
    }
}
