<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MoodType;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Entry;
use App\Models\Journal;
use App\Models\Mood;
use App\Models\User;
use App\Services\CreateMood;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateMoodTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_mood(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::create(2024, 3, 17));

        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Daily Journal',
        ]);
        $entry = Entry::factory()->create([
            'journal_id' => $journal->id,
            'day' => 17,
            'month' => 3,
            'year' => 2024,
        ]);

        $mood = (new CreateMood(
            user: $user,
            entry: $entry,
            moodType: MoodType::VERY_PLEASANT,
            comment: 'Had a great day!',
        ))->execute();

        $this->assertDatabaseHas('entries_mood', [
            'id' => $mood->id,
            'entry_id' => $entry->id,
        ]);

        $this->assertEquals(7, $mood->mood);
        $this->assertEquals('Had a great day!', $mood->comment);

        $this->assertDatabaseHas('entries_blocks', [
            'entry_id' => $entry->id,
            'position' => 1,
            'blockable_type' => Mood::class,
            'blockable_id' => $mood->id,
        ]);

        $this->assertInstanceOf(
            Mood::class,
            $mood,
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
                return $job->action === 'mood_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created a mood entry for Sunday March 17th, 2024';
            },
        );
    }

    #[Test]
    public function it_throws_an_exception_if_the_entry_does_not_belong_to_the_account(): void
    {
        $this->expectException(Exception::class);

        $user = User::factory()->create();
        $journal = Journal::factory()->create();
        $entry = Entry::factory()->create([
            'journal_id' => $journal->id,
        ]);

        (new CreateMood(
            user: $user,
            entry: $entry,
            moodType: MoodType::VERY_PLEASANT,
        ))->execute();
    }

    #[Test]
    public function it_throws_an_exception_if_the_entry_already_has_a_mood(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Entry already has a mood');

        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $entry = Entry::factory()->create([
            'journal_id' => $journal->id,
        ]);
        Mood::factory()->create([
            'entry_id' => $entry->id,
        ]);

        (new CreateMood(
            user: $user,
            entry: $entry,
            moodType: MoodType::VERY_PLEASANT,
        ))->execute();
    }
}
