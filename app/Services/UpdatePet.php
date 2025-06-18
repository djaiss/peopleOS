<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Pet;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePet
{
    public function __construct(
        private readonly User $user,
        private readonly Pet $pet,
        private readonly ?string $name = null,
        private readonly ?string $species = null,
        private readonly ?string $breed = null,
        private readonly ?string $gender = null,
        private readonly ?Person $person = null,
    ) {}

    public function execute(): Pet
    {
        $this->validate();
        $this->update();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->pet;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->pet->account_id) {
            throw new ModelNotFoundException();
        }

        if ($this->person && $this->person->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->pet->update([
            'name' => $this->name ?? $this->pet->name,
            'species' => $this->species ?? $this->pet->species,
            'breed' => $this->breed ?? $this->pet->breed,
            'gender' => $this->gender ?? $this->pet->gender,
            'person_id' => $this->person?->id ?? $this->pet->person_id,
        ]);
    }

    private function updatePersonLastConsultedDate(): void
    {
        if ($this->person) {
            UpdatePersonLastConsultedDate::dispatch($this->person)->onQueue('low');
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'pet_update',
            description: 'Updated a pet: ' . $this->pet->name,
        )->onQueue('low');
    }
}
