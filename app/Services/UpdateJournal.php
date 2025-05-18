<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\JournalTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateJournal
{
    public function __construct(
        public User $user,
        public Journal $journal,
        public ?JournalTemplate $journalTemplate,
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

        if ($this->journalTemplate && $this->journalTemplate->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException('Journal template not found');
        }
    }

    private function updateJournal(): void
    {
        $this->journal->update([
            'name' => $this->name,
            'journal_template_id' => $this->journalTemplate?->id,
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
