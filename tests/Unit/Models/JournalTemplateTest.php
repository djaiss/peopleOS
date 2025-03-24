<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\JournalTemplate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JournalTemplateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $journalTemplate = JournalTemplate::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($journalTemplate->account()->exists());
    }
}
