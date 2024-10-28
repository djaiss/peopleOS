<?php

namespace App\Jobs;

use App\Cache\UserVaultsCache;
use App\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Clear all the caches related to vault in the account.
 */
class ClearCacheOfAllVaultsInAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Account $account,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $vaults = $this->account->vaults()->get();

        foreach ($vaults as $vault) {
            $users = $vault->users()->get();
            foreach ($users as $user) {
                //UserVaultsCache::make($user)->forget();
            }
        }
    }
}
