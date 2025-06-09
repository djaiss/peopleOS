<?php

declare(strict_types=1);

namespace App\Cache;

use App\Helpers\CacheHelper;
use App\Helpers\JournalHelper;
use App\Traits\CacheIdentifier;
use Illuminate\Support\Collection;

/**
 * Cache all the days for the journal.
 */
final class JournalDaysCache extends CacheHelper
{
    use CacheIdentifier;

    protected string $key = 'account.journal-days:%s';

    protected int $ttl = 604800; // 1 week

    private int $year;
    private int $month;
    private int $day;

    public function __construct(
        int $accountId,
        int $year,
        int $month,
        int $day,
    ) {
        $this->identifier = $accountId . ':' . $year . ':' . $month . ':' . $day;
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    public static function make(int $accountId, int $year, int $month, int $day): static
    {
        return new self($accountId, $year, $month, $day);
    }

    protected function generate(): Collection
    {
        return JournalHelper::getDaysInMonth(
            givenYear: $this->year,
            givenMonth: $this->month,
            givenDay: $this->day,
        );
    }
}
