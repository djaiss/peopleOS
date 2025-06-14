<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use Exception;

class CreateWorkHistory
{
    private WorkHistory $workHistory;

    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly ?string $companyName,
        private readonly string $jobTitle,
        private readonly ?string $estimatedSalary,
        private readonly ?string $duration,
        private readonly bool $active,
    ) {}

    public function execute(): WorkHistory
    {
        $this->validate();
        $this->create();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->workHistory;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new Exception('User and person are not in the same account');
        }
    }

    private function create(): void
    {
        $this->workHistory = WorkHistory::create([
            'person_id' => $this->person->id,
            'company_name' => $this->companyName ?? null,
            'job_title' => $this->jobTitle,
            'estimated_salary' => $this->estimatedSalary ?? null,
            'duration' => $this->duration ?? null,
            'active' => $this->active,
        ]);

        if ($this->active) {
            // make all the other work histories inactive, except for the
            // one we just created
            $this->person->workHistories()
                ->where('active', true)
                ->where('id', '!=', $this->workHistory->id)->update([
                    'active' => false,
                ]);
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'work_history_creation',
            description: 'Created a work history entry for ' . $this->person->name,
        )->onQueue('low');
    }
}
