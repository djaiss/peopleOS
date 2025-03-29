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

    #[Test]
    public function it_gets_the_details_of_the_journal_template(): void
    {
        $yaml = <<<'YAML'
        template:
          columns:
            - name: "Morning"
              questions:
                - name: "Sleep quality"
                  answers:
                    type: "range"
                    range: [1, 5]
                    comment_allowed: true
                - name: "Sleep quality"
                  answers:
                    type: "range"
                    range: [1, 5]
                    comment_allowed: true
            - name: "Afternoon"
              questions:
                - name: "Sleep quality"
                  answers:
                    type: "range"
                    range: [1, 5]
                    comment_allowed: true
        YAML;

        $journalTemplate = JournalTemplate::factory()->create([
            'content' => $yaml,
        ]);

        $this->assertEquals([
            'columns' => 2,
            'questions' => 3,
        ], $journalTemplate->getDetails());
    }

    #[Test]
    public function it_gets_an_empty_details_if_the_yaml_is_empty(): void
    {
        $journalTemplate = JournalTemplate::factory()->create([
            'content' => '',
        ]);

        $this->assertEquals([
            'columns' => 0,
            'questions' => 0,
        ], $journalTemplate->getDetails());
    }
}
