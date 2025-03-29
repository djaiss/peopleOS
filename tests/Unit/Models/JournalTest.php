<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Journal;
use App\Models\JournalTemplate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JournalTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($journal->account()->exists());
    }

    #[Test]
    public function it_belongs_to_a_journal_template(): void
    {
        $journalTemplate = JournalTemplate::factory()->create();
        $journal = Journal::factory()->create([
            'journal_template_id' => $journalTemplate->id,
        ]);

        $this->assertTrue($journal->journalTemplate()->exists());
    }
}
