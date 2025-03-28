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

        $journalTemplate = (new CreateJournalTemplate(
            user: $user,
            name: 'Test template',
            content: 'Test content',
        ))->execute();

        $this->assertDatabaseHas('journal_templates', [
            'id' => $journalTemplate->id,
            'account_id' => $account->id,
        ]);

        $this->assertEquals('Test template', $journalTemplate->name);
        $this->assertEquals('Test content', $journalTemplate->content);

        Queue::assertPushed(UpdateUserLastActivityDate::class);
        Queue::assertPushed(LogUserAction::class, function ($job) {
            return $job->action === 'journal_template_creation' &&
                $job->description === 'Created the journal template called Test template';
        });
    }
}
