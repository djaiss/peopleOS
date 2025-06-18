<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyPet
{
    public function __construct(
        private readonly User $user,
        private readonly Pet $pet,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $petName = $this->pet->name;

        $this->pet->delete();

        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction($petName);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->pet->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        if ($this->pet->person) {
            UpdatePersonLastConsultedDate::dispatch($this->pet->person)->onQueue('low');
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(string $petName): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'pet_deletion',
            description: 'Deleted a pet: ' . $petName,
        )->onQueue('low');
    }
}
