<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\User;
use App\Services\CreateJournalTemplate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateJournalTemplateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_journal_template(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $account = Account::factory()->create();
        $user->account_id = $account->id;
        $user->save();

        $validYaml = <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "Morning"
      questions:
        - name: "Sleep quality"
          answers:
            type: "range"
            range: [1, 5]
            comment_allowed: true
YAML;

        $journalTemplate = (new CreateJournalTemplate(
            user: $user,
            name: 'Test template',
            content: $validYaml,
        ))->execute();

        $this->assertDatabaseHas('journal_templates', [
            'id' => $journalTemplate->id,
            'account_id' => $account->id,
        ]);

        $this->assertEquals('Test template', $journalTemplate->name);
        $this->assertEquals($validYaml, $journalTemplate->content);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) {
                return $job->action === 'journal_template_creation' &&
                    $job->description === 'Created the journal template called Test template';
            }
        );
    }
}
