<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\JournalDaysCache;
use App\Cache\JournalMonthsCache;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Mood;
use App\Models\User;
use Exception;

class DestroyMood
{
    public function __construct(
        private readonly User $user,
        private readonly Mood $mood,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
        $this->refreshCache();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->mood->entry->journal->account_id) {
            throw new Exception('Mood does not belong to the account');
        }
    }

    private function destroy(): void
    {
        $this->mood->block->delete();
        $this->mood->delete();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'mood_destroy',
            description: 'Destroyed a mood entry for ' . $this->mood->entry->getDate(),
        )->onQueue('low');
    }

    private function refreshCache(): void
    {
        JournalMonthsCache::make(
            accountId: $this->user->account_id,
            year: $this->mood->entry->year,
            selectedMonth: $this->mood->entry->month,
        )->refresh();

        JournalDaysCache::make(
            accountId: $this->user->account_id,
            year: $this->mood->entry->year,
            month: $this->mood->entry->month,
            day: $this->mood->entry->day,
        )->refresh();
    }
}
