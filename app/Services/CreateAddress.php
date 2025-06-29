<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Address;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Create an address.
 */
class CreateAddress
{
    private Address $address;

    public function __construct(
        public User $user,
        public ?Person $person = null,
        public ?string $addressLine1 = null,
        public ?string $addressLine2 = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $postalCode = null,
        public ?string $country = null,
        public bool $isActive = true,
    ) {}

    public function execute(): Address
    {
        $this->validate();
        $this->create();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->address;
    }

    private function validate(): void
    {
        if ($this->person && $this->person->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function create(): void
    {
        $this->address = Address::create([
            'account_id' => $this->user->account_id,
            'person_id' => $this->person?->id,
            'address_line_1' => $this->addressLine1,
            'address_line_2' => $this->addressLine2,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postalCode,
            'country' => $this->country,
            'is_active' => $this->isActive,
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
        $description = 'Created an address';

        if ($this->person) {
            $description .= ' for ' . $this->person->name;
        }

        LogUserAction::dispatch(
            user: $this->user,
            action: 'address_creation',
            description: $description,
        )->onQueue('low');
    }
}
