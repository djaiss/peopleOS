<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyContact
{
    public function __construct(
        public User $user,
        public Vault $vault,
        public Contact $contact,
    ) {
    }

    public function execute(): void
    {
        $this->validate();

        $this->contact->delete();
    }

    public function validate(): void
    {
        if ($this->vault->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException;
        }

        // make sure the user has the permission to delete the contact
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->vault->id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }

        // make sure the contact belongs to the vault
        if ($this->contact->vault_id !== $this->vault->id) {
            throw new ModelNotFoundException;
        }

        if (! $this->contact->can_be_deleted) {
            throw new ModelNotFoundException;
        }
    }
}
