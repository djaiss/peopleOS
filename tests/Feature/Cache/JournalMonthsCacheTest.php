<?php

declare(strict_types=1);

namespace Tests\Feature\Cache;

use App\Cache\JournalMonthsCache;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use ReflectionClass;

class JournalMonthsCacheTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_generates_correct_cache_key_format(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalMonthsCache::make(
            accountId: 456,
            year: 2025,
            selectedMonth: 3,
        );

        $expectedKey = 'account.journal-months:456:2025:3';

        $this->assertEquals($expectedKey, $cache->getKey());
    }

    #[Test]
    public function it_has_correct_ttl_property(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalMonthsCache::make(
            accountId: 789,
            year: 2025,
            selectedMonth: 6,
        );

        $reflection = new ReflectionClass($cache);
        $ttlProperty = $reflection->getProperty('ttl');
        $ttlProperty->setAccessible(true);

        $this->assertEquals(604800, $ttlProperty->getValue($cache));
    }

    #[Test]
    public function it_returns_collection_from_generate_method(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalMonthsCache::make(
            accountId: 111,
            year: 2025,
            selectedMonth: 1,
        );

        $reflection = new ReflectionClass($cache);
        $generateMethod = $reflection->getMethod('generate');
        $generateMethod->setAccessible(true);

        $result = $generateMethod->invoke($cache);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(12, $result);
        $this->assertTrue($result[1]['is_selected']);
        $this->assertFalse($result[2]['is_selected']);
        $this->assertEquals('January', $result[1]['month_name']);
        $this->assertEquals('December', $result[12]['month_name']);
    }

    #[Test]
    public function it_caches_data_correctly_through_value_method(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalMonthsCache::make(
            accountId: 222,
            year: 2025,
            selectedMonth: 3,
        );

        $result = $cache->value();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(12, $result);
        $this->assertTrue($result[3]['is_selected']);
        $this->assertEquals('March', $result[3]['month_name']);
    }

    #[Test]
    public function it_handles_various_valid_years_and_months(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $testCases = [
            ['accountId' => 100, 'year' => 2020, 'selectedMonth' => 1],
            ['accountId' => 200, 'year' => 2025, 'selectedMonth' => 12],
            ['accountId' => 300, 'year' => 2030, 'selectedMonth' => 6],
        ];

        foreach ($testCases as $testCase) {
            $cache = JournalMonthsCache::make(
                accountId: $testCase['accountId'],
                year: $testCase['year'],
                selectedMonth: $testCase['selectedMonth'],
            );

            $expectedKey = sprintf(
                'account.journal-months:%d:%d:%d',
                $testCase['accountId'],
                $testCase['year'],
                $testCase['selectedMonth'],
            );

            $this->assertEquals($expectedKey, $cache->getKey());

            $result = $cache->value();
            $this->assertInstanceOf(Collection::class, $result);
            $this->assertCount(12, $result);
            $this->assertTrue($result[$testCase['selectedMonth']]['is_selected']);
        }
    }

    #[Test]
    public function it_handles_different_account_ids_in_cache_key(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $accountIds = [1, 999, 123456789];

        foreach ($accountIds as $accountId) {
            $cache = JournalMonthsCache::make(
                accountId: $accountId,
                year: 2025,
                selectedMonth: 1,
            );

            $expectedKey = "account.journal-months:{$accountId}:2025:1";

            $this->assertEquals($expectedKey, $cache->getKey());
        }
    }

    #[Test]
    public function it_handles_edge_case_months(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $edgeCaseMonths = [1, 12];

        foreach ($edgeCaseMonths as $month) {
            $cache = JournalMonthsCache::make(
                accountId: 555,
                year: 2025,
                selectedMonth: $month,
            );

            $result = $cache->value();
            $this->assertInstanceOf(Collection::class, $result);
            $this->assertCount(12, $result);
            $this->assertTrue($result[$month]['is_selected']);
        }
    }

    #[Test]
    public function it_can_forget_cache(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalMonthsCache::make(
            accountId: 333,
            year: 2025,
            selectedMonth: 4,
        );

        // First populate the cache
        $cache->value();

        // Then forget it
        $result = $cache->forget();

        $this->assertIsBool($result);
    }

    #[Test]
    public function it_can_refresh_cache(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalMonthsCache::make(
            accountId: 444,
            year: 2025,
            selectedMonth: 5,
        );

        $result = $cache->refresh();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(12, $result);
        $this->assertTrue($result[5]['is_selected']);
        $this->assertEquals('May', $result[5]['month_name']);
    }
}
