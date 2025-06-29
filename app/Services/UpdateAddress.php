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
 * Update an address.
 */
class UpdateAddress
{
    public function __construct(
        public User $user,
        public Address $address,
        public ?string $addressLine1 = null,
        public ?string $addressLine2 = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $postalCode = null,
        public ?string $country = null,
        public ?bool $isActive = null,
    ) {}

    public function execute(): Address
    {
        $this->validate();
        $this->update();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->address;
    }

    private function validate(): void
    {
        if ($this->address->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->address->update([
            'address_line_1' => $this->addressLine1 ?? $this->address->address_line_1,
            'address_line_2' => $this->addressLine2 ?? $this->address->address_line_2,
            'city' => $this->city ?? $this->address->city,
            'state' => $this->state ?? $this->address->state,
            'postal_code' => $this->postalCode ?? $this->address->postal_code,
            'country' => $this->country ?? $this->address->country,
            'is_active' => $this->isActive ?? $this->address->is_active,
        ]);
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
        $description = 'Updated an address';

        if ($this->address->person) {
            $description .= ' for ' . $this->address->person->name;
        }

        LogUserAction::dispatch(
            user: $this->user,
            action: 'address_update',
            description: $description,
        )->onQueue('low');
    }
}
