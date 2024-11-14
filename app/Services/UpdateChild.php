<?php

namespace App\Services;

use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateChild
{
    public function __construct(
        public User $user,
        public Child $child,
        public ?string $name,
        public string $gender,
    ) {}

    public function execute(): Child
    {
        $this->validate();
        $this->update();

        return $this->child;
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

    private function update(): void
    {
        $this->child->name = $this->name ?? null;
        $this->child->gender = $this->gender;
        $this->child->save();
    }
}
