<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Pet;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Create a pet.
 */
class CreatePet
{
    private Pet $pet;

    public function __construct(
        public User $user,
        public Account $account,
        public string $species,
        public ?string $name = null,
        public ?string $breed = null,
        public ?string $gender = null,
        public ?Person $person = null,
    ) {}

    /**
     * Execute the service.
     *
     * @return Pet
     */
    public function execute(): Pet
    {
        $this->validate();
        $this->create();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->pet;
    }

    /**
     * Validate the user/account relationship.
     *
     * @return void
     */
    private function validate(): void
    {
        if ($this->user->account_id !== $this->account->id) {
            throw new ModelNotFoundException();
        }

        if ($this->person && $this->person->account_id !== $this->account->id) {
            throw new ModelNotFoundException();
        }
    }

    /**
     * Create the pet.
     *
     * @return void
     */
    private function create(): void
    {
        $this->pet = Pet::create([
            'account_id' => $this->account->id,
            'person_id' => $this->person?->id,
            'name' => $this->name,
            'species' => $this->species,
            'breed' => $this->breed,
            'gender' => $this->gender,
        ]);
    }

    /**
     * Update the last consulted date for the person, if set.
     *
     * @return void
     */
    private function updatePersonLastConsultedDate(): void
    {
        if ($this->person instanceof Person) {
            UpdatePersonLastConsultedDate::dispatch($this->person)->onQueue('low');
        }
    }

    /**
     * Update the user's last activity date.
     *
     * @return void
     */
    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    /**
     * Log the user action.
     *
     * @return void
     */
    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'pet_creation',
            description: 'Logged a pet: ' . $this->name,
        )->onQueue('low');
    }
}
