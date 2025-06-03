<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Account;
use App\Models\SpecialDate;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessUsersTrialEndingSoon implements ShouldQueue
{
    use Queueable;

    /**
     * Check if any users have a trial ending soon and send them an email.
     */
    public function handle(): void
    {
        $accounts = Account::where('trial_ends_at', '>', now()->addDays(5)->startOfDay())
            ->where('trial_ends_at', '<', now()->addDays(5)->endOfDay())
            ->where('has_lifetime_access', false)
            ->get();

        foreach ($accounts as $account) {
            foreach ($account->users as $user) {
                SendTrialEndingSoonEmail::dispatch($user->email)->onQueue('low');
            }
        }
    }
}
