<?php

namespace App\Services;

use App\Models\Child;
use App\Models\Contact;
use App\Models\MaritalStatus;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreatePartner
{
    private Partner $partner;

    public function __construct(
        public User $user,
        public Contact $contact,
        public MaritalStatus $maritalStatus,
        public ?string $name,
        public ?string $occupation,
    ) {}

    public function execute(): Partner
    {
        $this->validate();
        $this->create();

        return $this->partner;
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

        if ($this->maritalStatus->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException;
        }
    }

    private function create(): void
    {
        $this->partner = Partner::create([
            'contact_id' => $this->contact->id,
            'marital_status_id' => $this->maritalStatus->id,
            'name' => $this->name ?? null,
            'occupation' => $this->occupation ?? null,
        ]);
    }
}
