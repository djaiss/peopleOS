<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\JournalTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class CreateJournal
{
    public Journal $journal;

    public function __construct(
        public User $user,
        public ?JournalTemplate $journalTemplate,
        public string $name,
    ) {}

    public function execute(): Journal
    {
        $this->validate();
        $this->createJournal();
        $this->generateSlug();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->journal;
    }

    private function validate(): void
    {
        if ($this->journalTemplate
            && $this->journalTemplate->account_id !== $this->user->account_id) {
            // The journal template does not belong to the user's account.
            throw new ModelNotFoundException('Journal template not found');
        }
    }

    private function createJournal(): void
    {
        $this->journal = Journal::create([
            'account_id' => $this->user->account_id,
            'name' => $this->name,
            'journal_template_id' => $this->journalTemplate?->id,
        ]);
    }

    private function generateSlug(): void
    {
        $slug = $this->journal->id . '-' . Str::of($this->name)->slug('-');

        $this->journal->slug = $slug;
        $this->journal->save();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'journal_creation',
            description: 'Created the journal called ' . $this->journal->name,
        )->onQueue('low');
    }
}
