<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PersonsListCache;
use App\Models\FoodAllergy;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Support\Collection;

class GetFoodListing
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

        return [
            'persons' => $persons,
            'person' => $this->person,
            'food_allergies' => $this->getFoodAllergies(),
        ];
    }

    public function getFoodAllergies()
    {
        $foodAllergiesCollection = collect();

        $foodAllergiesCollection->push(
            $this->allergy($this->person),
        );

        // get lover allergies
        $activeRelationships = LoveRelationship::where(function ($query): void {
            $query->where('person_id', $this->person->id)
                ->orWhere('related_person_id', $this->person->id);
        })
            ->where('is_current', true)
            ->with([
                'person',
                'relatedPerson',
            ])
            ->get();

        $activeRelationships->each(function (LoveRelationship $relationship) use ($foodAllergiesCollection): void {
            $lover = null;

            if ($relationship->person_id === $this->person->id && $relationship->relatedPerson) {
                $lover = $relationship->relatedPerson;
            } elseif ($relationship->related_person_id === $this->person->id && $relationship->person) {
                $lover = $relationship->person;
            }

            if ($lover) {
                $foodAllergiesCollection->push(
                    $this->allergy($lover)
                );
            }
        });

        $uniqueAllergiesCollection = $foodAllergiesCollection->unique(function ($item) {
            return $item['id'];
        });

        return $uniqueAllergiesCollection->values()->toArray();
    }

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
