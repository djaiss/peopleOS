<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MoodType;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Mood;
use App\Models\User;
use Exception;

class UpdateMood
{
    public function __construct(
        private readonly User $user,
        private readonly Mood $mood,
        private readonly MoodType $moodType,
        private readonly ?string $comment = null,
    ) {}

    public function execute(): Mood
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->mood;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->mood->entry->journal->account_id) {
            throw new Exception('Mood does not belong to the account');
        }
    }

    private function update(): void
    {
        $this->mood->update([
            'mood' => $this->moodType->getDetails(),
            'comment' => $this->comment,
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
            action: 'mood_update',
            description: 'Updated a mood entry for '.$this->mood->entry->getDate(),
        )->onQueue('low');
    }
}
