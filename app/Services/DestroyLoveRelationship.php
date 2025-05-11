<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LoveRelationship;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyLoveRelationship
{
    public function __construct(
        public User $user,
        public LoveRelationship $loveRelationship,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->deleteLoveRelationship();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        $exists = LoveRelationship::where('id', $this->loveRelationship->id)
            ->whereHas('person', function ($query): void {
                $query->where('account_id', $this->user->account_id);
            })
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException('Relationship not found in user\'s account');
        }
    }

    private function deleteLoveRelationship(): void
    {
        // we need to check whether one of the person had the `is_listed` set to false
        // if so, we need to delete the entire person model after deleting the relationship
        $person = $this->loveRelationship->person;
        $relatedPerson = $this->loveRelationship->relatedPerson;

        if (! $person->is_listed) {
            $person->delete();
        }

        if (! $relatedPerson->is_listed) {
            $relatedPerson->delete();
        }

        // Delete both the relationship and its reverse
        LoveRelationship::where(function ($query): void {
            $query->where('person_id', $this->loveRelationship->person_id)
                ->where('related_person_id', $this->loveRelationship->related_person_id);
        })->orWhere(function ($query): void {
            $query->where('person_id', $this->loveRelationship->related_person_id)
                ->where('related_person_id', $this->loveRelationship->person_id);
        })->delete();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'love_relationship_deletion',
            description: "Deleted a {$this->loveRelationship->type} relationship between {$this->loveRelationship->person->name} and {$this->loveRelationship->relatedPerson->name}"
        )->onQueue('low');
    }
}
