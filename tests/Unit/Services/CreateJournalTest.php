<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Journal;
use App\Models\User;
use App\Services\CreateJournal;
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
            name: $name,
        ))->execute();

        $this->assertDatabaseHas('journals', [
            'id' => $journal->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertEquals('My Travel Journal', $journal->name);
        $this->assertEquals($journal->id . '-my-travel-journal', $journal->slug);

        $this->assertInstanceOf(
            Journal::class,
            $journal,
        );

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
                return $job->action === 'journal_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created the journal called My Travel Journal';
            },
        );
    }
}
