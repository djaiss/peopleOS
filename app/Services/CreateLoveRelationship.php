<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateLoveRelationship
{
    private LoveRelationship $loveRelationship;

    public function __construct(
        public User $user,
        public Person $person,
        public Person $relatedPerson,
        public string $type,
        public bool $isCurrent = false,
        public ?string $notes = null,
    ) {}

    public function execute(): LoveRelationship
    {
        $this->validate();
        $this->createLoveRelationship();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->loveRelationship;
    }

    private function validate(): void
    {
        // Make sure both persons belong to the same account as the user
        $count = Person::where('account_id', $this->user->account_id)
            ->whereIn('id', [$this->person->id, $this->relatedPerson->id])
            ->count();

        if ($count !== 2) {
            throw new ModelNotFoundException('One or both persons not found in user\'s account');
        }

        // Make sure that the relationship doesn't already exist
        $existingRelationship = LoveRelationship::where('person_id', $this->person->id)
            ->where('related_person_id', $this->relatedPerson->id)
            ->first();

        if ($existingRelationship) {
            throw new ModelNotFoundException('Relationship already exists');
        }
    }

    private function createLoveRelationship(): void
    {
        $this->loveRelationship = LoveRelationship::create([
            'person_id' => $this->person->id,
            'related_person_id' => $this->relatedPerson->id,
            'type' => $this->type,
            'is_current' => $this->isCurrent,
            'notes' => $this->notes,
        ]);

        // we also create the reverse relationship
        LoveRelationship::create([
            'person_id' => $this->relatedPerson->id,
            'related_person_id' => $this->person->id,
            'type' => $this->type,
            'is_current' => $this->isCurrent,
            'notes' => $this->notes,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'love_relationship_creation',
            description: "Created a {$this->type} relationship between {$this->person->name} and {$this->relatedPerson->name}"
        );
    }
}
