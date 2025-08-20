<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\User;
use App\Services\UpdateJournal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateJournalTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_journal(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Old name',
        ]);
        $newName = 'New Travel Journal';

        $updatedJournal = (new UpdateJournal(
            user: $user,
            journal: $journal,
            name: $newName,
        ))->execute();

        $this->assertDatabaseHas('journals', [
            'id' => $updatedJournal->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertEquals('New Travel Journal', $updatedJournal->name);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'journal_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated the journal called New Travel Journal';
            },
        );
    }

    #[Test]
    public function it_fails_if_journal_does_not_belong_to_user(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateJournal(
            user: $user,
            journal: $journal,
            name: 'New name',
        ))->execute();
    }
}
