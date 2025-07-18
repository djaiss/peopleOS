<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Models\WorkHistory;
use Exception;

class UpdateWorkHistory
{
    public function __construct(
        private readonly User $user,
        private readonly WorkHistory $workHistory,
        private readonly ?string $companyName,
        private readonly ?string $jobTitle,
        private readonly ?string $estimatedSalary,
        private readonly ?string $duration,
        private readonly bool $active,
    ) {}

    public function execute(): WorkHistory
    {
        $this->validate();

        $this->workHistory->update([
            'company_name' => $this->companyName,
            'job_title' => $this->jobTitle,
            'estimated_salary' => $this->estimatedSalary,
            'duration' => $this->duration,
            'active' => $this->active,
        ]);

        if ($this->active) {
            // make all the other work histories inactive, except for the
            // one we just updated
            $this->workHistory->person->workHistories()
                ->where('active', true)
                ->where('id', '!=', $this->workHistory->id)->update([
                    'active' => false,
                ]);
        }

        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->workHistory;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->workHistory->person->account_id) {
            throw new Exception('User and work history are not in the same account');
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->workHistory->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'work_history_update',
            description: 'Updated the work history entry for ' . $this->workHistory->person->name,
        )->onQueue('low');
    }
}
