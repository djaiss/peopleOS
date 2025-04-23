<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Account;
use App\Models\Entry;
use App\Models\Journal;
use App\Models\Mood;
use App\Models\User;
use App\Services\DestroyMood;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class DestroyMoodTest extends \Tests\TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_destroy_a_mood_entry(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);
        $journal = Journal::factory()->create([
            'account_id' => $account->id,
        ]);
        $entry = Entry::factory()->create([
            'journal_id' => $journal->id,
        ]);
        $mood = Mood::factory()->create([
            'entry_id' => $entry->id,
        ]);

        (new DestroyMood(
            user: $user,
            mood: $mood,
        ))->execute();

        $this->assertDatabaseMissing('entries_mood', [
            'id' => $mood->id,
        ]);
    }

    #[Test]
    public function it_should_throw_an_exception_if_mood_does_not_belong_to_account(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);
        $otherAccount = Account::factory()->create();
        $otherJournal = Journal::factory()->create([
            'account_id' => $otherAccount->id,
        ]);
        $entry = Entry::factory()->create([
            'journal_id' => $otherJournal->id,
        ]);
        $mood = Mood::factory()->create([
            'entry_id' => $entry->id,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Mood does not belong to the account');

        (new DestroyMood(
            user: $user,
            mood: $mood,
        ))->execute();
    }
}
