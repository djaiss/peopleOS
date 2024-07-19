<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateNote
{
    private Note $note;

    public function __construct(
        public User $user,
        public Contact $contact,
        public ?string $body,
    ) {}

    public function execute(): Note
    {
        $this->validate();
        $this->createNote();
        $this->updateLastEditedDate();

        return $this->note;
    }

    private function validate(): void
    {
        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->contact->vault_id)
            ->wherePivot('permission', '<=', Vault::PERMISSION_EDIT)
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

    private function updateLastEditedDate(): void
    {
        $this->contact->last_updated_at = Carbon::now();
        $this->contact->save();
    }
}
