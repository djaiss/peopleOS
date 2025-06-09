<?php

declare(strict_types=1);

namespace App\Cache;

use App\Helpers\CacheHelper;
use App\Helpers\JournalHelper;
use App\Traits\CacheIdentifier;
use Illuminate\Support\Collection;

/**
 * Cache all the months for the journal.
 */
final class JournalMonthsCache extends CacheHelper
{
    use CacheIdentifier;

    protected string $key = 'account.journal-months:%s';

    protected int $ttl = 604800; // 1 week

    private int $year;
    private int $selectedMonth;

    public function __construct(
        int $accountId,
        int $year,
        int $selectedMonth,
    ) {
        $this->identifier = $accountId . ':' . $year . ':' . $selectedMonth;
        $this->year = $year;
        $this->selectedMonth = $selectedMonth;
    }

    public static function make(int $accountId, int $year, int $selectedMonth): static
    {
        return new self($accountId, $year, $selectedMonth);
    }

    protected function generate(): Collection
    {
        return JournalHelper::getMonths(
            year: $this->year,
            selectedMonth: $this->selectedMonth,
        );
    }
}
