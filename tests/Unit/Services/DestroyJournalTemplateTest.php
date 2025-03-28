<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\JournalTemplate;
use App\Models\User;
use App\Services\DestroyJournalTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyJournalTemplateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_journal_template(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $journalTemplate = JournalTemplate::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Test template',
        ]);

        (new DestroyJournalTemplate(
            user: $user,
            journalTemplate: $journalTemplate,
        ))->execute();

        $this->assertDatabaseMissing('journal_templates', [
            'id' => $journalTemplate->id,
        ]);

        Queue::assertPushed(UpdateUserLastActivityDate::class);
        Queue::assertPushed(LogUserAction::class, function ($job) {
            return $job->action === 'journal_template_deletion' &&
                $job->description === 'Deleted the journal template called Test template';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $journalTemplate = JournalTemplate::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyJournalTemplate(
            user: $user,
            journalTemplate: $journalTemplate,
        ))->execute();
    }
}
