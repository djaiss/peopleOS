<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Note;
use App\Models\User;
use Exception;

class DestroyNote
{
    public function __construct(
        private readonly User $user,
        private readonly Note $note,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $this->note->delete();

        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->note->person->account_id) {
            throw new Exception('User and note are not in the same account');
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->note->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'note_deletion',
            description: 'Deleted a note for '.$this->note->person->name,
        )->onQueue('low');
    }
}
