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
        public ?int $age,
        public ?string $gradeLevel,
        public ?string $school,
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
        $this->child->age = $this->age ?? null;
        $this->child->grade_level = $this->gradeLevel ?? null;
        $this->child->school = $this->school ?? null;
        $this->child->age_entered_at = $this->age ? now() : null;
        $this->child->save();
    }
}
