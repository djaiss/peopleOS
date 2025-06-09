<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MoodType;
use App\Models\Entry;
use App\Models\EntryBlock;
use App\Models\Journal;
use App\Models\Mood;
use App\Models\User;
use App\Services\GetEntryBlocks;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetEntryBlocksTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_the_data_needed_for_viewing_an_entry(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $entry = Entry::factory()->create([
            'journal_id' => $journal->id,
            'day' => 1,
            'month' => 1,
            'year' => 2023,
        ]);

        $array = (new GetEntryBlocks(
            entry: $entry,
        ))->execute();

        $this->assertArrayHasKeys(
            $array,
            [
                'options', 'entry', 'days', 'months', 'blocks',
            ],
        );

        $this->assertInstanceOf(
            Entry::class,
            $array['entry'],
        );
    }

    #[Test]
    public function it_gets_the_mood_block(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $entry = Entry::factory()->create([
            'journal_id' => $journal->id,
            'day' => 1,
            'month' => 1,
            'year' => 2023,
        ]);
        $mood = Mood::factory()->create([
            'entry_id' => $entry->id,
            'mood' => MoodType::VERY_UNPLEASANT->getDetails(),
            'comment' => 'This is a comment',
        ]);
        EntryBlock::factory()->create([
            'entry_id' => $entry->id,
            'blockable_id' => $mood->id,
            'blockable_type' => Mood::class,
        ]);

        $array = (new GetEntryBlocks(
            entry: $entry,
        ))->execute();

        $this->assertCount(1, $array['blocks']);
        $this->assertEquals([
            'type' => 'mood',
            'data' => [
                'id' => $mood->id,
                'mood' => 1,
                'comment' => 'This is a comment',
            ],
            'created_at' => '2018-01-01 00:00:00',
        ], $array['blocks'][0]);
    }
}
