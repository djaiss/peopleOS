<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateNote
{
    private Contact $contact;

    public function __construct(
        public User $user,
        public Note $note,
        public string $body,
    ) {
    }

    public function execute(): Note
    {
        $this->validate();
        $this->update();

        return $this->note;
    }

    private function validate(): void
    {
        $this->contact = $this->note->contact;

        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->contact->vault_id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }
    }

    private function update(): void
    {
        $this->note->body = $this->body;
        $this->note->save();
    }
}
