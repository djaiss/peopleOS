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
        public Person $parent,
        public ?Person $secondParent = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
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
        $exists = Person::where('account_id', $this->user->account_id)
            ->whereIn('id', [
                $this->parent->id,
                $this->secondParent?->id,
            ])
            ->exists();

        if (!$exists) {
            throw new ModelNotFoundException('One or more persons not found in user\'s account');
        }
    }

    private function create(): void
    {
        $this->child = Child::create([
            'account_id' => $this->user->account_id,
            'parent_id' => $this->parent->id,
            'second_parent_id' => $this->secondParent?->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ]);
    }

    private function changeKidsStatus(): void
    {
        (new UpdateParentRelationshipStatus(
            person: $this->parent,
        ))->execute();

        if ($this->secondParent instanceof Person) {
            (new UpdateParentRelationshipStatus(
                person: $this->secondParent,
            ))->execute();
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->parent)->onQueue('low');

        if ($this->secondParent instanceof Person) {
            UpdatePersonLastConsultedDate::dispatch($this->secondParent)->onQueue('low');
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        $description = "Created a child for {$this->parent->name}";

        if ($this->secondParent instanceof Person) {
            $description .= " and {$this->secondParent->name}";
        }

        LogUserAction::dispatch(
            user: $this->user,
            action: 'child_relationship_creation',
            description: $description,
        )->onQueue('low');
    }
}
