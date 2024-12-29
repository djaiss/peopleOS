<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateContactPhoneNumber
{
    private Contact $contact;

    public function __construct(
        public User $user,
        public ContactPhoneNumber $contactPhoneNumber,
        public string $label,
        public string $phoneNumber,
    ) {
    }

    public function execute(): ContactPhoneNumber
    {
        $this->validate();
        $this->update();

        return $this->contactPhoneNumber;
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

    private function update(): void
    {
        $this->contactPhoneNumber->label = $this->label;
        $this->contactPhoneNumber->phone_number = $this->phoneNumber;
        $this->contactPhoneNumber->save();
    }
}
