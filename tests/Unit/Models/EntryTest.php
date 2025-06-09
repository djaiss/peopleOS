<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Entry;
use App\Models\EntryBlock;
use App\Models\Journal;
use App\Models\Mood;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EntryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_journal(): void
    {
        $journal = Journal::factory()->create();
        $entry = Entry::factory()->create([
            'journal_id' => $journal->id,
        ]);

        $this->assertTrue($entry->journal()->exists());
    }

    #[Test]
    public function it_has_a_mood(): void
    {
        $entry = Entry::factory()->create();
        Mood::factory()->create([
            'entry_id' => $entry->id,
        ]);

        $this->assertTrue($entry->mood()->exists());
    }

    #[Test]
    public function it_has_blocks(): void
    {
        $entry = Entry::factory()->create();
        EntryBlock::factory()->create([
            'entry_id' => $entry->id,
        ]);

        $this->assertTrue($entry->blocks()->exists());
    }

    #[Test]
    public function it_gets_the_date(): void
    {
        $entry = Entry::factory()->create([
            'year' => 2024,
            'month' => 12,
            'day' => 23,
        ]);

        $this->assertEquals('Monday December 23rd, 2024', $entry->getDate());
    }
}
