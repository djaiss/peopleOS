<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\User;
use App\Services\DestroyJournal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyJournalTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_journal(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Journal to delete',
        ]);

        (new DestroyJournal(
            user: $user,
            journal: $journal,
        ))->execute();

        $this->assertDatabaseMissing('journals', [
            'id' => $journal->id,
        ]);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'journal_deletion'
                && $job->user->id === $user->id
                && $job->description === 'Deleted the journal called Journal to delete';
        });
    }

    #[Test]
    public function it_fails_if_journal_does_not_belong_to_user(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyJournal(
            user: $user,
            journal: $journal,
        ))->execute();
    }
}
