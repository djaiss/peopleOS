<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Entry;
use App\Models\Journal;
use App\Models\User;
use App\Services\CreateOrRetrieveEntry;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateOrRetrieveEntryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_an_entry(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Test Journal',
        ]);

        $entry = (new CreateOrRetrieveEntry(
            user: $user,
            journal: $journal,
            day: 1,
            month: 1,
            year: 2024,
        ))->execute();

        $this->assertDatabaseHas('entries', [
            'id' => $entry->id,
            'journal_id' => $journal->id,
            'day' => 1,
            'month' => 1,
            'year' => 2024,
        ]);

        $this->assertInstanceOf(
            Entry::class,
            $entry
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'entry_creation'
                && $job->user->id === $user->id
                && $job->description === 'Created the entry for the journal called Test Journal';
        });
    }

    #[Test]
    public function it_retrieves_an_existing_entry(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $existingEntry = Entry::factory()->create([
            'journal_id' => $journal->id,
            'day' => 1,
            'month' => 1,
            'year' => 2024,
        ]);

        $entry = (new CreateOrRetrieveEntry(
            user: $user,
            journal: $journal,
            day: 1,
            month: 1,
            year: 2024,
        ))->execute();

        $this->assertEquals($existingEntry->id, $entry->id);
    }

    #[Test]
    public function it_fails_if_journal_doesnt_belong_to_user(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new CreateOrRetrieveEntry(
            user: $user,
            journal: $journal,
            day: 1,
            month: 1,
            year: 2024,
        ))->execute();
    }

    #[Test]
    public function it_fails_if_date_is_invalid(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid date');

        (new CreateOrRetrieveEntry(
            user: $user,
            journal: $journal,
            day: 31,
            month: 2,
            year: 2024,
        ))->execute();
    }
}
