<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\FoodAllergy;
use App\Models\User;
use Exception;

class UpdateFoodAllergy
{
    public function __construct(
        private readonly User $user,
        private readonly FoodAllergy $foodAllergy,
        private readonly string $name,
    ) {}

    public function execute(): FoodAllergy
    {
        $this->validate();
        $this->update();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->foodAllergy;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->foodAllergy->person->account_id) {
            throw new Exception('User and person are not in the same account');
        }
    }

    private function update(): void
    {
        $this->foodAllergy->update([
            'name' => $this->name,
        ]);
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->foodAllergy->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'food_allergy_updated',
            description: 'Updated a food allergy for ' . $this->foodAllergy->person->name . ': ' . $this->name,
        )->onQueue('low');
    }
}
