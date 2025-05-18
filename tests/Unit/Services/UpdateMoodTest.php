<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MoodType;
use App\Models\Account;
use App\Models\Entry;
use App\Models\Journal;
use App\Models\Mood;
use App\Models\User;
use App\Services\UpdateMood;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class UpdateMoodTest extends \Tests\TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_update_a_mood_entry(): void
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
            'mood' => MoodType::NEUTRAL->getDetails(),
        ]);

        $mood = (new UpdateMood(
            user: $user,
            mood: $mood,
            moodType: MoodType::VERY_PLEASANT,
            comment: 'Could I BE any happier?',
        ))->execute();

        $this->assertEquals(
            MoodType::VERY_PLEASANT->getDetails(),
            $mood->fresh()->mood,
        );
        $this->assertEquals(
            'Could I BE any happier?',
            $mood->fresh()->comment,
        );
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

        (new UpdateMood(
            user: $user,
            mood: $mood,
            moodType: MoodType::VERY_PLEASANT,
        ))->execute();
    }
}
