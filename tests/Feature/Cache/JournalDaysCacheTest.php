<?php

declare(strict_types=1);

namespace Tests\Feature\Cache;

use App\Cache\JournalDaysCache;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use ReflectionClass;

class JournalDaysCacheTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_generates_correct_cache_key_format(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalDaysCache::make(
            accountId: 456,
            year: 2025,
            month: 3,
            day: 15,
        );

        $expectedKey = 'account.journal-days:456:2025:3:15';

        $this->assertEquals($expectedKey, $cache->getKey());
    }

    #[Test]
    public function it_has_correct_ttl_property(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalDaysCache::make(
            accountId: 789,
            year: 2025,
            month: 6,
            day: 10,
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

        $cache = JournalDaysCache::make(
            accountId: 111,
            year: 2025,
            month: 1,
            day: 15,
        );

        $reflection = new ReflectionClass($cache);
        $generateMethod = $reflection->getMethod('generate');
        $generateMethod->setAccessible(true);

        $result = $generateMethod->invoke($cache);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(31, $result);
        $this->assertTrue($result[15]['is_selected']);
        $this->assertFalse($result[14]['is_selected']);
        $this->assertFalse($result[16]['is_selected']);
    }

    #[Test]
    public function it_caches_data_correctly_through_value_method(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalDaysCache::make(
            accountId: 222,
            year: 2025,
            month: 3,
            day: 20,
        );

        $result = $cache->value();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(31, $result);
        $this->assertTrue($result[20]['is_selected']);
        $this->assertFalse($result[19]['is_selected']);
    }

    #[Test]
    public function it_handles_various_valid_years_months_and_days(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $testCases = [
            ['accountId' => 100, 'year' => 2020, 'month' => 1, 'day' => 1],
            ['accountId' => 200, 'year' => 2025, 'month' => 12, 'day' => 31],
            ['accountId' => 300, 'year' => 2030, 'month' => 6, 'day' => 15],
        ];

        foreach ($testCases as $testCase) {
            $cache = JournalDaysCache::make(
                accountId: $testCase['accountId'],
                year: $testCase['year'],
                month: $testCase['month'],
                day: $testCase['day'],
            );

            $expectedKey = sprintf(
                'account.journal-days:%d:%d:%d:%d',
                $testCase['accountId'],
                $testCase['year'],
                $testCase['month'],
                $testCase['day'],
            );

            $this->assertEquals($expectedKey, $cache->getKey());

            $result = $cache->value();
            $this->assertInstanceOf(Collection::class, $result);
            $this->assertTrue($result[$testCase['day']]['is_selected']);
        }
    }

    #[Test]
    public function it_handles_different_account_ids_in_cache_key(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $accountIds = [1, 999, 123456789];

        foreach ($accountIds as $accountId) {
            $cache = JournalDaysCache::make(
                accountId: $accountId,
                year: 2025,
                month: 1,
                day: 5,
            );

            $expectedKey = "account.journal-days:{$accountId}:2025:1:5";

            $this->assertEquals($expectedKey, $cache->getKey());
        }
    }

    #[Test]
    public function it_handles_edge_case_days(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $edgeCaseDays = [
            ['month' => 1, 'day' => 1, 'expectedCount' => 31],
            ['month' => 1, 'day' => 31, 'expectedCount' => 31],
            ['month' => 2, 'day' => 1, 'expectedCount' => 28],
            ['month' => 2, 'day' => 28, 'expectedCount' => 28],
        ];

        foreach ($edgeCaseDays as $testCase) {
            $cache = JournalDaysCache::make(
                accountId: 555,
                year: 2025,
                month: $testCase['month'],
                day: $testCase['day'],
            );

            $result = $cache->value();
            $this->assertInstanceOf(Collection::class, $result);
            $this->assertCount($testCase['expectedCount'], $result);
            $this->assertTrue($result[$testCase['day']]['is_selected']);
        }
    }

    #[Test]
    public function it_handles_leap_year_february(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        // Test leap year (2024)
        $cache = JournalDaysCache::make(
            accountId: 666,
            year: 2024,
            month: 2,
            day: 29,
        );

        $result = $cache->value();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(29, $result);
        $this->assertTrue($result[29]['is_selected']);

        // Test non-leap year (2025)
        $cache = JournalDaysCache::make(
            accountId: 777,
            year: 2025,
            month: 2,
            day: 28,
        );

        $result = $cache->value();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(28, $result);
        $this->assertTrue($result[28]['is_selected']);
    }

    #[Test]
    public function it_can_forget_cache(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $cache = JournalDaysCache::make(
            accountId: 333,
            year: 2025,
            month: 4,
            day: 12,
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

        $cache = JournalDaysCache::make(
            accountId: 444,
            year: 2025,
            month: 5,
            day: 18,
        );

        $result = $cache->refresh();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(31, $result);
        $this->assertTrue($result[18]['is_selected']);
        $this->assertFalse($result[17]['is_selected']);
        $this->assertFalse($result[19]['is_selected']);
    }
}
