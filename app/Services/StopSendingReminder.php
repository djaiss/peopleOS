<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\SpecialDate;
use App\Models\User;
use App\Models\WorkHistory;
use Exception;

/**
 * This service is used called when a user clicks on the "Stop sending reminders"
 * button in a reminder email.
 */
class StopSendingReminder
{
    public function __construct(
        private readonly User $user,
        private SpecialDate $specialDate,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $this->update();

        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->specialDate->account_id) {
            throw new Exception('User and special date are not in the same account');
        }
    }

    private function update(): void
    {
        $this->specialDate->update([
            'should_be_reminded' => false,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'stop_sending_reminder',
            description: 'Marked a reminder as no longer sent for '.$this->specialDate->person->name,
        )->onQueue('low');
    }
}
