<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Delete an account if there is no activity for all users after a period of
 * time.
 */
class DestroyAccountBecauseInactivity
{
    public function __construct(
        private readonly Account $account
    ) {}

    public function execute(): void
    {
        $users = $this->account->users()->select('id', 'last_activity_at')->get();
        $inactiveUsers = $users->filter(function (User $user): bool {
            // If the user has never logged in (null last_activity_at)
            if ($user->last_activity_at === null) {
                return true;
            }

            // Check if the user has been inactive for 6 months
            return $user->last_activity_at->diffInMonths(now()) >= 6;
        });

        if ($inactiveUsers->count() === $users->count()) {
            Log::info('Deleting account because all users are inactive: ' . $this->account->id);
            $this->account->delete();
            Log::info('Account deleted: ' . $this->account->id);
        } else {
            Log::info('Not deleting account because not all users are inactive: ' . $this->account->id);
        }
    }
}
