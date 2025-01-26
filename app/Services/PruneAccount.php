<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Person;
use App\Models\User;
use Exception;

class PruneAccount
{
    public function __construct(
        public User $user,
        public Account $account,
    ) {}

    /**
     * Prune the account by deleting all persons and related data.
     */
    public function execute(): void
    {
        $this->validate();
        $this->deletePersons();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->account->id) {
            throw new Exception('User does not belong to account');
        }
    }

    private function deletePersons(): void
    {
        Person::where('account_id', $this->account->id)->delete();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'account_pruning',
            description: 'Deleted all persons and related data from your account',
        );
    }
}
