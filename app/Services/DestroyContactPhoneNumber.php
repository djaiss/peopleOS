<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyContactPhoneNumber
{
    private Contact $contact;

    public function __construct(
        public User $user,
        public ContactPhoneNumber $contactPhoneNumber,
    ) {
    }

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
    }

    private function validate(): void
    {
        $this->contact = $this->contactPhoneNumber->contact;

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
        $this->contactPhoneNumber->delete();
    }
}
