<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Person;
use Illuminate\Support\Collection;

class GetFoodListing
{
    public function __construct(
        private readonly Person $person,
    ) {}

    /**
     * Execute the service and return the result.
     *
     * @return array The result of the service
     */
    public function execute(): array
    {
        return [
            'food_allergies' => $this->getFoodAllergies(),
        ];
    }

    /**
     * Get the food allergies for the person.
     *
     * @return Collection The food allergies for the person
     */
    public function getFoodAllergies(): Collection
    {
        $foodAllergiesCollection = collect();

        $foodAllergiesCollection->push(
            $this->allergy($this->person),
        );

        // get lover allergies
        foreach ($this->person->getActivePartnersAsPersonCollection() as $partner) {
            $foodAllergiesCollection->push($this->allergy($partner));
        }

        // remove potential duplicates entries
        $uniqueAllergiesCollection = $foodAllergiesCollection->unique(fn(array $item) => $item['id']);

        // remove any entries without allergies
        $uniqueAllergiesCollection = $uniqueAllergiesCollection->filter(fn($item): bool => !empty($item['food_allergies']));

        return $uniqueAllergiesCollection->values();
    }

    /**
     * Get the allergy data for a person.
     *
     * @param Person $person The person to get the allergy data for
     * @return array The allergy data
     */
    public function allergy(Person $person): array
    {
        return [
            'id' => $person->id,
            'name' => $person->name,
            'is_listed' => $person->is_listed,
            'slug' => $person->slug,
            'avatar' => [
                '40' => $person->getAvatar(40),
                '80' => $person->getAvatar(80),
            ],
            'food_allergies' => $person->food_allergies,
        ];
    }
}
