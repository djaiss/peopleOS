<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyNote
{
    private Contact $contact;

    public function __construct(
        public User $user,
        public Note $note,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
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

    private function destroy(): void
    {
        $this->note->delete();
    }
}
