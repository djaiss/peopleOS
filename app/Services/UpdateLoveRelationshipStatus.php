<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MaritalStatusType;
use App\Models\LoveRelationship;
use App\Models\Person;

/**
 * This service checks if there is a current love relationship for the given
 * person.
 */
class UpdateLoveRelationshipStatus
{
    public function __construct(
        public Person $person,
    ) {}

    public function execute(): void
    {
        // check if there are any current love relationships for the given person
        $exists = LoveRelationship::where(function ($query): void {
            $query->where('person_id', $this->person->id)
                ->orWhere('related_person_id', $this->person->id);
        })
            ->where('is_current', true)
            ->exists();

        if ($exists) {
            $relationshipStatus = MaritalStatusType::COUPLE->value;
        } else {
            $relationshipStatus = MaritalStatusType::SINGLE->value;
        }

        $this->person->marital_status = $relationshipStatus;
        $this->person->save();
    }
}
