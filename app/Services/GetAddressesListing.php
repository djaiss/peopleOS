<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PersonsListCache;
use App\Models\Address;
use App\Models\Person;
use App\Models\User;

class GetAddressesListing
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
    ) {}

    public function execute(): array
    {
        $persons = PersonsListCache::make(
            accountId: $this->user->account_id,
        )->value();

        $addresses = Address::where('person_id', $this->person->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(Address $address): array => [
                'id' => $address->id,
                'address_line_1' => $address->address_line_1,
                'address_line_2' => $address->address_line_2,
                'city' => $address->city,
                'state' => $address->state,
                'postal_code' => $address->postal_code,
                'country' => $address->country,
                'is_active' => $address->is_active,
                'created_at' => $address->created_at->format('M j, Y'),
            ]);

        return [
            'person' => $this->person,
            'persons' => $persons,
            'addresses' => $addresses,
        ];
    }
}
