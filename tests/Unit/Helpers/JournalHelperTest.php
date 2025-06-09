<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use App\Helpers\JournalHelper;
use App\Models\Entry;
use App\Models\EntryBlock;
use App\Models\Mood;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JournalHelperTest extends TestCase
{
    #[Test]
    public function it_returns_all_the_months_in_a_given_year(): void
    {
        $entry = Entry::factory()->create([
            'year' => 2023,
            'month' => 3,
        ]);
        Entry::factory()->create([
            'year' => 2023,
            'month' => 2,
        ]);

        $mood = Mood::factory()->create([
            'entry_id' => $entry->id,
        ]);
        EntryBlock::factory()->create([
            'entry_id' => $entry->id,
            'blockable_id' => $mood->id,
            'blockable_type' => Mood::class,
        ]);

        $collection = JournalHelper::getMonths(
            year: 2023,
            selectedMonth: 3,
        );

        $this->assertCount(12, $collection);
        $this->assertEquals([
            'month' => 1,
            'month_name' => 'January',
            'entries_count' => 0,
            'is_selected' => false,
            'url' => env('APP_URL') . '/journal/2023/1/1',
        ], $collection[1]);
        $this->assertEquals([
            'month' => 3,
            'month_name' => 'March',
            'entries_count' => 1,
            'is_selected' => true,
            'url' => env('APP_URL') . '/journal/2023/3/1',
        ], $collection[3]);
    }

    #[Test]
    public function it_returns_all_the_days_in_a_given_month(): void
    {
        Carbon::setTestNow(Carbon::create(2023, 2, 3));

        $collection = JournalHelper::getDaysInMonth(
            givenYear: 2023,
            givenMonth: 2,
            givenDay: 3,
        );

        $this->assertCount(28, $collection);
        $this->assertEquals([
            'day' => 3,
            'is_today' => true,
            'is_selected' => true,
            'url' => env('APP_URL') . '/journal/2023/2/3',
            'has_blocks' => false,
        ], $collection[3]);
        $this->assertEquals([
            'day' => 28,
            'is_today' => false,
            'is_selected' => false,
            'url' => env('APP_URL') . '/journal/2023/2/28',
            'has_blocks' => false,
        ], $collection[28]);
    }
}
