<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateContactPhoneNumber
{
    private ContactPhoneNumber $contactPhoneNumber;

    public function __construct(
        public User $user,
        public Contact $contact,
        public string $label,
        public string $phoneNumber,
    ) {
    }

    public function execute(): ContactPhoneNumber
    {
        $this->validate();
        $this->create();

        return $this->contactPhoneNumber;
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

    private function create(): void
    {
        $this->contactPhoneNumber = ContactPhoneNumber::create([
            'contact_id' => $this->contact->id,
            'label' => $this->label,
            'phone_number' => $this->phoneNumber,
        ]);
    }
}
