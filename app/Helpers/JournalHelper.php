<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Entry;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * This class is responsible for providing helper methods related to the journal.
 */
class JournalHelper
{
    /**
     * Get all the months in the year, with the current month marked as selected.
     * For each months, get the number of non-empty entries in that month.
     * Returns the following structure:
     * [
     *    1 => [
     *      'month' => 1,
     *      'month_name' => 'January',
     *      'entries_count' => 5,
     *      'is_selected' => false,
     *      'url' => '/journal/2023/01',
     *   ]
     *
     * @param int $year The year to get the months for.
     * @param int $selectedMonth The month to mark as selected.
     *
     * @return Collection The months in the year.
     */
    public static function getMonths(int $year, int $selectedMonth): Collection
    {
        // Get entry counts for all months in a single query
        $entryCounts = Entry::where('year', $year)
            ->whereHas('blocks')
            ->selectRaw('month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return collect(range(1, 12))->mapWithKeys(fn(int $month) => [
            $month => [
                'month' => $month,
                'month_name' => date('F', mktime(0, 0, 0, $month, 1, $year)),
                'entries_count' => $entryCounts[$month] ?? 0,
                'is_selected' => $month === $selectedMonth,
                'url' => route('journal.entry.show', [
                    'day' => 1,
                    'year' => $year,
                    'month' => $month,
                ]),
            ],
        ]);
    }

    /**
     * Get the days in a given month of the given year.
     * Returns the following structure:
     * [
     *    1 => [
     *      'day' => 1,
     *      'is_today' => false,
     *      'is_selected' => false,
     *      'has_blocks' => true,
     *      'url' => '/journal/2023/01/01',
     *   ]
     *
     * @param int $givenYear The year to get the days for.
     * @param int $givenMonth The month to get the days for.
     * @param int $givenDay The day to mark as selected.
     *
     * @return Collection The days in the month.
     */
    public static function getDaysInMonth(int $givenYear, int $givenMonth, int $givenDay): Collection
    {
        // Get all days that have blocks in a single query
        $daysWithBlocks = Entry::where('year', $givenYear)
            ->where('month', $givenMonth)
            ->whereHas('blocks')
            ->pluck('day')
            ->flip()
            ->toArray();

        return collect(range(1, cal_days_in_month(CAL_GREGORIAN, $givenMonth, $givenYear)))
            ->mapWithKeys(fn(int $day) => [
                $day => [
                    'day' => $day,
                    'is_today' => Carbon::createFromDate($givenYear, $givenMonth, $day)->isToday(),
                    'is_selected' => $day === $givenDay,
                    'has_blocks' => isset($daysWithBlocks[$day]),
                    'url' => route('journal.entry.show', [
                        'year' => $givenYear,
                        'month' => $givenMonth,
                        'day' => $day,
                    ]),
                ],
            ]);
    }
}
