<?php

declare(strict_types=1);

namespace App\Services;

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
        $months = $this->getMonths();
        $days = $this->getDaysInMonth();

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

    public function getMonths(): Collection
    {
        return collect(range(1, 12))->mapWithKeys(fn (int $month) => [
            $month => [
                'month' => $month,
                'month_name' => date('F', mktime(0, 0, 0, $month, 1, $this->year)),
                'is_selected' => $month === $this->month,
                'url' => route('journal.entry.show', [
                    'day' => 1,
                    'year' => $this->year,
                    'month' => $month,
                ]),
            ],
        ]);
    }

    /**
     * Get all the
     *
     * @return integer
     */
    public function getDaysInMonth(): Collection
    {
        return collect(range(1, cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year)))
            ->mapWithKeys(fn (int $day) => [
                $day => [
                    'day' => $day,
                    'is_today' => $day === (int) now()->format('d') && $this->month === (int) now()->format('m') && $this->year === (int) now()->format('Y'),
                    'is_selected' => $day === $this->day,
                    'url' => route('journal.entry.show', [
                        'year' => $this->year,
                        'month' => $this->month,
                        'day' => $day,
                    ]),
                ],
            ]);
    }
}
