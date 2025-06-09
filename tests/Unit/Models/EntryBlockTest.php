<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Entry;
use App\Models\EntryBlock;
use App\Models\Mood;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EntryBlockTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_entry(): void
    {
        $entry = Entry::factory()->create();
        $entryBlock = EntryBlock::factory()->create([
            'entry_id' => $entry->id,
        ]);

        $this->assertTrue($entryBlock->entry()->exists());
        $this->assertEquals(
            $entry->id,
            $entryBlock->entry->id,
        );
    }

    #[Test]
    public function it_has_a_polymorphic_relationship_to_blockable(): void
    {
        $mood = Mood::factory()->create();
        $entryBlock = EntryBlock::factory()->create([
            'blockable_type' => Mood::class,
            'blockable_id' => $mood->id,
        ]);

        $this->assertInstanceOf(Mood::class, $entryBlock->blockable);
        $this->assertEquals(
            $mood->id,
            $entryBlock->blockable->id,
        );
    }
}
