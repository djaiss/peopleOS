<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * This class is responsible for providing helper methods related to the journal.
 */
class JournalHelper
{
    /**
     * Get all the months in the year, with the current month marked as selected.
     * Returns the following structure:
     * [
     *    1 => [
     *      'month' => 1,
     *      'month_name' => 'January',
     *      'is_selected' => false,
     *      'url' => '/journal/2023/01',
     *   ]
     */
    public static function getMonths(int $year, int $selectedMonth): Collection
    {
        return collect(range(1, 12))->mapWithKeys(fn(int $month) => [
            $month => [
                'month' => $month,
                'month_name' => date('F', mktime(0, 0, 0, $month, 1, $year)),
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
     *      'url' => '/journal/2023/01/01',
     *   ]
     */
    public static function getDaysInMonth(int $givenYear, int $givenMonth, int $givenDay): Collection
    {
        return collect(range(1, cal_days_in_month(CAL_GREGORIAN, $givenMonth, $givenYear)))
            ->mapWithKeys(fn(int $day) => [
                $day => [
                    'day' => $day,
                    'is_today' => Carbon::createFromDate($givenYear, $givenMonth, $day)->isToday(),
                    'is_selected' => $day === $givenDay,
                    'url' => route('journal.entry.show', [
                        'year' => $givenYear,
                        'month' => $givenMonth,
                        'day' => $day,
                    ]),
                ],
            ]);
    }
}
