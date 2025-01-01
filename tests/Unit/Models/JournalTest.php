<?php

namespace Tests\Unit\Models;

use App\Models\Day;
use App\Models\Journal;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JournalTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_vault(): void
    {
        $journal = Journal::factory()->create();
        $this->assertTrue($journal->vault()->exists());
    }

    #[Test]
    public function it_has_many_days(): void
    {
        $journal = Journal::factory()->create();
        Day::factory()->create([
            'journal_id' => $journal->id,
        ]);

        $this->assertTrue($journal->days()->exists());
    }
}
