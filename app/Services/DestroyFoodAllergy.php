<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use Exception;

class DestroyFoodAllergy
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
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
        if ($this->user->account_id !== $this->person->account_id) {
            throw new Exception('User and person are not in the same account');
        }
    }

    private function destroy(): void
    {
        $this->person->food_allergies = null;
        $this->person->save();
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
            action: 'food_allergy_destroyed',
            description: 'Deleted a food allergy for ' . $this->person->name,
        )->onQueue('low');
    }
}
