<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\JournalHelper;
use App\Models\Entry;
use App\Models\Gender;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Support\Collection;

class GetEntryData
{
    private Journal $journal;
    private Entry $entry;

    public function __construct(
        private readonly User $user,
        private readonly int $day,
        private readonly int $month,
        private readonly int $year,
    ) {}

    public function execute(): array
    {
        $this->getJournal();
        $this->getEntry();
        $days = JournalHelper::getDaysInMonth(
            givenYear: $this->year,
            givenMonth: $this->month,
            givenDay: $this->day,
        );
        $months = JournalHelper::getMonths(
            year: $this->year,
            selectedMonth: $this->month,
        );

        return [
            'entry' => $this->entry,
            'days' => $days,
            'months' => $months,
        ];
    }

    public function getJournal(): void
    {
        // get the first journal in the account
        // currently, there is only one journal per account even though the
        // account can have multiple journals
        $this->journal = Journal::where('account_id', $this->user->account_id)->first();
    }

    public function getEntry(): void
    {
        $this->entry = (new CreateOrRetrieveEntry(
            user: $this->user,
            journal: $this->journal,
            day: $this->day,
            month: $this->month,
            year: $this->year,
        ))->execute();
    }
}
