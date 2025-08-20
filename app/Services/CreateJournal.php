<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Support\Str;

class CreateJournal
{
    public Journal $journal;

    public function __construct(
        public User $user,
        public string $name,
    ) {}

    public function execute(): Journal
    {
        $this->createJournal();
        $this->generateSlug();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->journal;
    }

    private function createJournal(): void
    {
        $this->journal = Journal::create([
            'account_id' => $this->user->account_id,
            'name' => $this->name,
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
