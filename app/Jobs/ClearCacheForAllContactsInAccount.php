<?php

namespace App\Jobs;

use App\Cache\ContactInformationCache;
use App\Models\Account;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Clear all the caches related to the account.
 * This is necessary when we change a major setting of the account, affecting
 * all the contacts. For instance, changing genders. If we don't clear the
 * cache there, the user would hit the caches about the contacts and encounter
 * the old data.
 */
class ClearCacheForAllContactsInAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Account $account,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $vaults = $this->account->vaults()->get();

        foreach ($vaults as $vault) {
            $users = $vault->users()->get();
            foreach ($users as $user) {
                $contacts = $vault->contacts()->lazy();

                foreach ($contacts as $contact) {
                    ContactInformationCache::make($user, $contact)->forget();
                }
            }
        }
    }
}
