<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\KidsStatusType;
use App\Enums\MaritalStatusType;
use App\Models\Child;
use App\Models\LoveRelationship;
use App\Models\Person;

class UpdateParentRelationshipStatus
{
    public function __construct(
        public Person $person,
    ) {}

    public function execute(): void
    {
        $exists = Child::where(function ($query): void {
            $query->where('parent_id', $this->person->id)
                ->orWhere('second_parent_id', $this->person->id);
        })
            ->exists();

        if ($exists) {
            $kidsStatus = KidsStatusType::HAS_KIDS->value;
        } else {
            $kidsStatus = KidsStatusType::NO_KIDS->value;
        }

        $this->person->kids_status = $kidsStatus;
        $this->person->save();
    }
}
