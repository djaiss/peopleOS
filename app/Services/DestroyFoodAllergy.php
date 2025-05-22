<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\FoodAllergy;
use App\Models\User;
use Exception;

class DestroyFoodAllergy
{
    public function __construct(
        private readonly User $user,
        private readonly FoodAllergy $foodAllergy,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->foodAllergy->person->account_id) {
            throw new Exception('User and person are not in the same account');
        }
    }

    private function destroy(): void
    {
        $this->foodAllergy->delete();
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
            action: 'food_allergy_destroyed',
            description: 'Deleted a food allergy for ' . $this->foodAllergy->person->name . ': ' . $this->foodAllergy->name,
        )->onQueue('low');
    }
}
