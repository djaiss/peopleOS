<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Note;
use App\Models\User;
use Exception;

class UpdateNote
{
    public function __construct(
        private readonly User $user,
        private readonly Note $note,
        private readonly string $content,
    ) {}

    public function execute(): Note
    {
        $this->validate();

        $this->note->update([
            'content' => $this->content,
        ]);

        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->note;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->note->person->account_id) {
            throw new Exception('User and note are not in the same account');
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'note_update',
            description: 'Updated the note for '.$this->note->person->name,
        )->onQueue('low');
    }
}
