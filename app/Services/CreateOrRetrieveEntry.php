<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Entry;
use App\Models\Journal;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Create or retrieve an entry for a journal.
 * If the entry already exists, it will be retrieved.
 */
class CreateOrRetrieveEntry
{
    public Entry $entry;

    public function __construct(
        public User $user,
        public Journal $journal,
        public int $day,
        public int $month,
        public int $year,
    ) {}

    public function execute(): Entry
    {
        $this->validate();
        $this->create();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->entry;
    }

    private function validate(): void
    {
        if ($this->journal->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException('Journal not found');
        }

        // check if the date is a real date
        if (! checkdate($this->month, $this->day, $this->year)) {
            throw new Exception('Invalid date');
        }
    }

    private function create(): void
    {
        $existingEntry = Entry::where('journal_id', $this->journal->id)
            ->where('day', $this->day)
            ->where('month', $this->month)
            ->where('year', $this->year)
            ->first();

        if ($existingEntry) {
            $this->entry = $existingEntry;
        } else {
            $this->entry = Entry::create([
                'journal_id' => $this->journal->id,
                'day' => $this->day,
                'month' => $this->month,
                'year' => $this->year,
            ]);
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'entry_creation',
            description: 'Created the entry for the journal called '.$this->journal->name,
        );
    }
}
