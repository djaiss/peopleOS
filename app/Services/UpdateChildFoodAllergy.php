<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Child;
use App\Models\User;
use Exception;

class UpdateChildFoodAllergy
{
    public function __construct(
        private readonly User $user,
        private readonly Child $child,
        private readonly string $name,
    ) {}

    public function execute(): Child
    {
        $this->validate();
        $this->create();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->child;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->child->account_id) {
            throw new Exception('User and child are not in the same account');
        }
    }

    private function create(): void
    {
        $this->child->food_allergies = $this->name;
        $this->child->save();
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->child->parent)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'child_food_allergy_updated',
            description: 'Updated a food allergy for ' . $this->child->name . ': ' . $this->name,
        )->onQueue('low');
    }
}
