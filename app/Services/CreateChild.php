<?php

namespace App\Services;

use App\Models\Child;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateChild
{
    private Child $child;

    public function __construct(
        public User $user,
        public Contact $contact,
        public ?string $gender,
        public ?string $name,
    ) {
    }

    public function execute(): Child
    {
        $this->validate();
        $this->createChild();
        $this->updateLastEditedDate();

        return $this->child;
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

    private function createChild(): void
    {
        $this->child = Child::create([
            'contact_id' => $this->contact->id,
            'gender' => $this->gender,
            'name' => $this->name,
        ]);
    }

    private function updateLastEditedDate(): void
    {
        $this->contact->last_updated_at = Carbon::now();
        $this->contact->save();
    }
}
