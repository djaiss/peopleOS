<?php

namespace App\Services;

use App\Models\Child;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateChild
{
    private Child $child;

    public function __construct(
        public User $user,
        public Contact $contact,
        public ?string $name,
        public string $gender,
        public ?string $age,
        public ?string $gradeLevel,
        public ?string $school,
    ) {}

    public function execute(): Child
    {
        $this->validate();
        $this->create();

        return $this->child;
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
        $this->child = Child::create([
            'contact_id' => $this->contact->id,
            'name' => $this->name ?? null,
            'gender' => $this->gender,
            'age' => $this->age ?? null,
            'grade_level' => $this->gradeLevel ?? null,
            'school' => $this->school ?? null,
            'age_entered_at' => $this->age ? now() : null,
        ]);
    }
}
