<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\JournalTemplate;
use App\Models\User;
use App\Services\CreateJournal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateJournalTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_journal(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $name = 'My Travel Journal';

        $journal = (new CreateJournal(
            user: $user,
            journalTemplate: null,
            name: $name,
        ))->execute();

        $this->assertDatabaseHas('journals', [
            'id' => $journal->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertEquals('My Travel Journal', $journal->name);
        $this->assertEquals($journal->id.'-my-travel-journal', $journal->slug);

        $this->assertInstanceOf(
            Journal::class,
            $journal
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'journal_creation'
                && $job->user->id === $user->id
                && $job->description === 'Created the journal called My Travel Journal';
        });
    }

    #[Test]
    public function it_creates_a_journal_from_a_journal_template(): void
    {
        $user = User::factory()->create();
        $journalTemplate = JournalTemplate::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $name = 'My Travel Journal';

        $journal = (new CreateJournal(
            user: $user,
            journalTemplate: $journalTemplate,
            name: $name,
        ))->execute();

        $this->assertDatabaseHas('journals', [
            'id' => $journal->id,
            'account_id' => $user->account_id,
            'journal_template_id' => $journalTemplate->id,
        ]);
    }

    #[Test]
    public function it_cant_create_a_journal_from_a_journal_template_that_does_not_belong_to_the_user(): void
    {
        $user = User::factory()->create();
        $journalTemplate = JournalTemplate::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new CreateJournal(
            user: $user,
            journalTemplate: $journalTemplate,
            name: 'My Travel Journal',
        ))->execute();
    }
}
