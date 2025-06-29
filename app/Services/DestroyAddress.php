<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Destroy an address.
 */
class DestroyAddress
{
    public function __construct(
        public User $user,
        public Address $address,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->updatePersonLastConsultedDate();
        $this->destroy();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->address->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function destroy(): void
    {
        $this->address->delete();
    }

    private function updatePersonLastConsultedDate(): void
    {
        if ($this->address->person) {
            UpdatePersonLastConsultedDate::dispatch($this->address->person)->onQueue('low');
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        $description = 'Destroyed an address';

        if ($this->address->person) {
            $description .= ' for ' . $this->address->person->name;
        }

        LogUserAction::dispatch(
            user: $this->user,
            action: 'address_deletion',
            description: $description,
        )->onQueue('low');
    }
}
