<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\JournalDaysCache;
use App\Cache\JournalMonthsCache;
use App\Enums\MoodType;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Entry;
use App\Models\Mood;
use App\Models\User;
use Exception;

class CreateMood
{
    private Mood $mood;

    public function __construct(
        private readonly User $user,
        private readonly Entry $entry,
        private readonly MoodType $moodType,
        private readonly ?string $comment = null,
    ) {}

    public function execute(): Mood
    {
        $this->validate();
        $this->create();
        $this->createEntryBlock();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
        $this->refreshCache();

        return $this->mood;
    }

    private function validate(): void
    {
        if ($this->entry->journal->account_id !== $this->user->account_id) {
            throw new Exception('Entry does not belong to the account');
        }

        if ($this->entry->mood()->exists()) {
            throw new Exception('Entry already has a mood');
        }
    }

    private function create(): void
    {
        $this->mood = Mood::create([
            'entry_id' => $this->entry->id,
            'mood' => $this->moodType->getDetails(),
            'comment' => $this->comment,
        ]);
    }

    private function createEntryBlock(): void
    {
        $position = $this->entry->blocks()->max('position') + 1;

        $this->entry->blocks()->create([
            'position' => $position,
            'blockable_id' => $this->mood->id,
            'blockable_type' => Mood::class,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'mood_creation',
            description: 'Created a mood entry for ' . $this->entry->getDate(),
        )->onQueue('low');
    }

    private function refreshCache(): void
    {
        JournalMonthsCache::make(
            accountId: $this->user->account_id,
            year: $this->entry->year,
            selectedMonth: $this->entry->month,
        )->refresh();

        JournalDaysCache::make(
            accountId: $this->user->account_id,
            year: $this->entry->year,
            month: $this->entry->month,
            day: $this->entry->day,
        )->refresh();
    }
}
