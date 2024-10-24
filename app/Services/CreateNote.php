<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateNote
{
    private Note $note;

    public function __construct(
        public User $user,
        public Contact $contact,
        public string $body,
    ) {}

    public function execute(): Note
    {
        $this->validate();
        $this->createNote();

        return $this->note;
    }

    private function validate(): void
    {
        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->contact->vault_id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }
    }

    private function createNote(): void
    {
        $this->note = Note::create([
            'contact_id' => $this->contact->id,
            'user_id' => $this->user->id,
            'body' => $this->body,
        ]);
    }
}
