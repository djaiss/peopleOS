<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\FoodAllergy;
use App\Models\Person;
use App\Models\User;
use Exception;

class CreateFoodAllergy
{
    private FoodAllergy $foodAllergy;

    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly string $name,
    ) {}

    public function execute(): FoodAllergy
    {
        $this->validate();
        $this->create();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->foodAllergy;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new Exception('User and person are not in the same account');
        }
    }

    private function create(): void
    {
        $this->foodAllergy = FoodAllergy::create([
            'person_id' => $this->person->id,
            'name' => $this->name,
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
            action: 'food_allergy_created',
            description: 'Created a food allergy for ' . $this->person->name . ': ' . $this->name,
        )->onQueue('low');
    }
}
