<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyPartner
{
    public function __construct(
        public User $user,
        public Partner $partner,
    ) {
    }

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
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
    }

    private function destroy(): void
    {
        $this->partner->delete();
    }
}
