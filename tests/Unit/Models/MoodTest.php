<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Entry;
use App\Models\EntryBlock;
use App\Models\Mood;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MoodTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_entry(): void
    {
        $entry = Entry::factory()->create();
        $mood = Mood::factory()->create([
            'entry_id' => $entry->id,
        ]);

        $this->assertTrue($mood->entry()->exists());
    }

    #[Test]
    public function it_has_a_block(): void
    {
        $entry = Entry::factory()->create();
        $mood = Mood::factory()->create();

        EntryBlock::factory()->create([
            'entry_id' => $entry->id,
            'blockable_id' => $mood->id,
            'blockable_type' => Mood::class,
        ]);

        $this->assertTrue($mood->block()->exists());
    }
}
