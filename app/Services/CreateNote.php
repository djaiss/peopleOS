<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Note;
use App\Models\Person;
use App\Models\User;
use Exception;

class CreateNote
{
    private Note $note;

    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly string $content,
    ) {}

    public function execute(): Note
    {
        $this->validate();
        $this->create();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->note;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new Exception('User and person are not in the same account');
        }
    }

    private function create(): void
    {
        $this->note = Note::create([
            'person_id' => $this->person->id,
            'content' => $this->content,
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
            action: 'note_creation',
            description: 'Created a note for '.$this->person->name,
        )->onQueue('low');
    }
}
