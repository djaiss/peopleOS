<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Entry;
use App\Models\Journal;
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
}
