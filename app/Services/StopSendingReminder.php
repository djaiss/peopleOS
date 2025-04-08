<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SpecialDate;
use App\Models\User;

/**
 * This service is used called when a user clicks on the "Stop sending reminders"
 * button in a reminder email.
 */
class StopSendingReminder
{
    public function __construct(
        private readonly SpecialDate $specialDate,
    ) {}

    public function execute(): void
    {
        $this->update();
    }

    private function update(): void
    {
        $this->specialDate->update([
            'should_be_reminded' => false,
        ]);
    }
}
