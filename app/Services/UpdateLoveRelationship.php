<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateLoveRelationship
{
    public function __construct(
        private readonly User $user,
        private readonly LoveRelationship $loveRelationship,
        private readonly Person $person,
        private readonly Person $relatedPerson,
        private readonly string $type,
        private readonly bool $isCurrent = false,
        private readonly ?string $notes = null,
    ) {}

    public function execute(): LoveRelationship
    {
        $this->validate();
        $this->update();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->loveRelationship;
    }

    private function validate(): void
    {
        // Make sure both persons belong to the same account as the user
        $count = Person::where('account_id', $this->user->account_id)
            ->whereIn('id', [
                $this->person->id,
                $this->relatedPerson->id,
            ])
            ->count();

        if ($count !== 2) {
            throw new ModelNotFoundException('One or both persons not found in user\'s account');
        }
    }

    private function update(): void
    {
        $this->loveRelationship->update([
            'person_id' => $this->person->id,
            'related_person_id' => $this->relatedPerson->id,
            'type' => $this->type,
            'is_current' => $this->isCurrent,
            'notes' => $this->notes,
        ]);
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'love_relationship_update',
            description: "Updated the {$this->type} relationship between {$this->person->name} and {$this->relatedPerson->name}",
        )->onQueue('low');
    }
}
