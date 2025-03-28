<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\JournalTemplate;
use App\Models\User;
use App\Services\UpdateJournalTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateJournalTemplateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_journal_template(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $journalTemplate = JournalTemplate::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Old name',
            'content' => 'Old content',
        ]);

        $updatedTemplate = (new UpdateJournalTemplate(
            user: $user,
            journalTemplate: $journalTemplate,
            name: 'New name',
            content: 'New content',
        ))->execute();

        $this->assertDatabaseHas('journal_templates', [
            'id' => $journalTemplate->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertEquals('New name', $updatedTemplate->name);
        $this->assertEquals('New content', $updatedTemplate->content);

        Queue::assertPushed(UpdateUserLastActivityDate::class);
        Queue::assertPushed(LogUserAction::class, function ($job) {
            return $job->action === 'journal_template_update' &&
                $job->description === 'Updated the journal template called New name';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $journalTemplate = JournalTemplate::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateJournalTemplate(
            user: $user,
            journalTemplate: $journalTemplate,
            name: 'New name',
            content: 'New content',
        ))->execute();
    }
}
