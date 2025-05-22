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

        $workHistories = WorkHistory::where('person_id', $this->person->id)
            ->get()
            ->map(fn(WorkHistory $history): array => [
                'id' => $history->id,
                'title' => $history->job_title,
                'company' => $history->company_name,
                'duration' => $history->duration,
                'salary' => $history->estimated_salary,
                'is_current' => $history->active,
            ]);

        return [
            'persons' => $persons,
            'person' => $this->person,
            'work_histories' => $workHistories,
        ];
    }

    public function getFoodAllergies()
    {
        // get person allergies
        $foodAllergies = $this->person->foodAllergies
            ->map(fn(FoodAllergy $allergy): array => $this->allergy($allergy))
            ->toArray();

        // get lover allergies
        $activeRelationships = LoveRelationship::where(function ($query) {
            $query->where('person_id', $this->person->id)
                ->orWhere('related_person_id', $this->person->id);
        })
            ->where('is_current', true)
            ->with([
                'person.foodAllergies',
                'relatedPerson.foodAllergies',
            ])
            ->get();

        $allLoverFoodAllergies = $activeRelationships->flatMap(function (LoveRelationship $relationship) {
            $lover = null;

            if ($relationship->person_id === $this->person->id && $relationship->relatedPerson) {
                $lover = $relationship->relatedPerson;
            } elseif ($relationship->related_person_id === $this->person->id && $relationship->person) {
                $lover = $relationship->person;
            }

            return $lover && $lover->foodAllergies ? $lover->foodAllergies : collect();
        });

        // $allLoverFoodAllergies is now a flat Collection of FoodAllergy models.
        // If you need only unique names, you can do:
        // $uniqueAllergyNames = $allLoverFoodAllergies->pluck('name')->unique()->values();

        return $allLoverFoodAllergies;

        return $foodAllergies;
    }

    public function allergy(FoodAllergy $allergy): array
    {
        return [
            'id' => $allergy->id,
            'name' => $allergy->name,
        ];
    }
}
