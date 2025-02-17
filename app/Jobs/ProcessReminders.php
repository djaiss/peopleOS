<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\SpecialDate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessReminders implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $specialDates = SpecialDate::where('should_be_reminded', true)
            ->where('month', now()->month)
            ->where('day', now()->day)
            ->get();

        foreach ($specialDates as $specialDate) {
            SendReminder::dispatch($specialDate);
        }
    }
}
