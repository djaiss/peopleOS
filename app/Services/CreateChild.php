<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Child;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateChild
{
    private Child $child;

    public function __construct(
        public User $user,
        public Person $person,
        public Person $parent,
        public ?Person $secondParent = null,
        public ?string $notes = null,
    ) {}

    public function execute(): Child
    {
        $this->validate();
        $this->create();
        $this->changeKidsStatus();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->child;
    }

    private function validate(): void
    {
        // Make sure all persons belong to the same account as the user
        $count = Person::where('account_id', $this->user->account_id)
            ->whereIn('id', [
                $this->parent->id,
                $this->person->id,
            ])
            ->count();

        if ($count !== 2) {
            throw new ModelNotFoundException('One or more persons not found in user\'s account');
        }

        // Make sure that the child doesn't already exist
        $existingChild = Child::where('parent_id', $this->parent->id)
            ->where('second_parent_id', $this->secondParent?->id)
            ->where('person_id', $this->person->id)
            ->first();

        if ($existingChild) {
            throw new ModelNotFoundException('Child already exists');
        }

        // Make sure that the child doesn't already exist in the reverse relationship
        $existingChild = Child::where('parent_id', $this->secondParent?->id)
            ->where('second_parent_id', $this->parent->id)
            ->where('person_id', $this->person->id)
            ->first();

        if ($existingChild) {
            throw new ModelNotFoundException('Child already exists');
        }
    }

    private function create(): void
    {
        $this->child = Child::create([
            'person_id' => $this->person->id,
            'parent_id' => $this->parent->id,
            'second_parent_id' => $this->secondParent?->id,
            'notes' => $this->notes,
        ]);
    }

    private function changeKidsStatus(): void
    {
        (new UpdateParentRelationshipStatus(
            person: $this->parent,
        ))->execute();

        if ($this->secondParent) {
            (new UpdateParentRelationshipStatus(
                person: $this->secondParent,
            ))->execute();
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->parent)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        $description = "Created a child for {$this->parent->name}";

        if ($this->secondParent) {
            $description .= " and {$this->secondParent->name}";
        }

        LogUserAction::dispatch(
            user: $this->user,
            action: 'child_relationship_creation',
            description: $description,
        )->onQueue('low');
    }
}
