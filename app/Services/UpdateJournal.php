<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateJournal
{
    public function __construct(
        public User $user,
        public Journal $journal,
        public string $name,
    ) {}

    public function execute(): Journal
    {
        $this->validate();
        $this->updateJournal();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->journal;
    }

    private function validate(): void
    {
        if ($this->journal->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException('Journal not found');
        }
    }

    private function updateJournal(): void
    {
        $this->journal->update([
            'name' => $this->name,
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
            action: 'journal_update',
            description: 'Updated the journal called ' . $this->journal->name,
        )->onQueue('low');
    }
}
