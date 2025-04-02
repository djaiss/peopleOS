<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyJournal
{
    public function __construct(
        private readonly User $user,
        private readonly Journal $journal,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $journalName = $this->journal->name;

        $this->journal->delete();

        $this->updateUserLastActivityDate();
        $this->logUserAction($journalName);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->journal->account_id) {
            throw new ModelNotFoundException('Journal not found');
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(string $journalName): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'journal_deletion',
            description: 'Deleted the journal called '.$journalName,
        )->onQueue('low');
    }
}
