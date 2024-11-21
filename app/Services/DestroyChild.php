<?php

namespace App\Services;

use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyChild
{
    public function __construct(
        public User $user,
        public Child $child,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
    }

    private function validate(): void
    {
        $contact = $this->child->contact;

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
        $this->child->delete();
    }
}
