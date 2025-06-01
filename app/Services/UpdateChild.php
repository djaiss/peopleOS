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

class UpdateChild
{
    public function __construct(
        private readonly User $user,
        private readonly Child $child,
        private readonly ?Person $parent = null,
        private readonly ?Person $secondParent = null,
        private readonly ?string $firstName = null,
        private readonly ?string $lastName = null,
    ) {}

    public function execute(): Child
    {
        $this->validate();
        $this->update();
        $this->changeKidsStatus();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->child;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->child->account_id) {
            throw new ModelNotFoundException('Child not found in user\'s account');
        }

        if ($this->parent && $this->parent->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException('Parent not found in user\'s account');
        }

        if ($this->secondParent && $this->secondParent->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException('Second parent not found in user\'s account');
        }
    }

    private function update(): void
    {
        $this->child->update([
            'parent_id' => $this->parent?->id,
            'second_parent_id' => $this->secondParent?->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ]);
    }

    private function changeKidsStatus(): void
    {
        if ($this->parent instanceof Person) {
            (new UpdateParentRelationshipStatus(
                person: $this->parent,
            ))->execute();
        }

        if ($this->secondParent instanceof Person) {
            (new UpdateParentRelationshipStatus(
                person: $this->secondParent,
            ))->execute();
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        $originalParent = Person::find($this->child->getOriginal('parent_id'));
        $orginalSecondParent = Person::find($this->child->getOriginal('second_parent_id'));

        if ($this->parent && $this->parent->id !== $originalParent?->id) {
            UpdatePersonLastConsultedDate::dispatch($this->parent)->onQueue('low');
        }

        if ($this->secondParent && $this->secondParent->id !== $orginalSecondParent?->id) {
            UpdatePersonLastConsultedDate::dispatch($this->secondParent)->onQueue('low');
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        $names = array_filter([
            $this->parent?->name,
            $this->secondParent?->name,
        ]);

        $sentence = match (count($names)) {
            2 => implode(' and ', $names),
            1 => $names[0],
            default => 'no one',
        };

        $description = "Updated a child for {$sentence}";

        LogUserAction::dispatch(
            user: $this->user,
            action: 'child_relationship_update',
            description: $description,
        )->onQueue('low');
    }
}
