<?php

namespace App\Services;

use App\Models\MaritalStatus;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePartner
{
    public function __construct(
        public User $user,
        public Partner $partner,
        public MaritalStatus $maritalStatus,
        public ?string $name,
        public ?string $occupation,
    ) {}

    public function execute(): Partner
    {
        $this->validate();
        $this->update();

        return $this->partner;
    }

    private function validate(): void
    {
        $contact = $this->partner->contact;

        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $contact->vault_id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }

        if ($this->maritalStatus->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException;
        }
    }

    private function update(): void
    {
        $this->partner->marital_status_id = $this->maritalStatus->id;
        $this->partner->name = $this->name ?? null;
        $this->partner->occupation = $this->occupation ?? null;
        $this->partner->save();
    }
}
