<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Account;
use App\Services\DestroyAccountBecauseInactivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class DeleteInactiveAccounts implements ShouldQueue
{
    use Queueable;

    /**
     * Delete all accounts which have been inactive for the last 6 months.
     */
    public function handle(): void
    {
        $accounts = Account::where('auto_delete_account', true)->get();

        foreach ($accounts as $account) {
            Log::info('Deleting account due to inactivity: '.$account->id);
            (new DestroyAccountBecauseInactivity($account))->execute();
        }
    }
}
