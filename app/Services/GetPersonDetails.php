<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PeopleListCache;
use App\Models\Person;
use App\Models\User;

class GetPersonDetails
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
    ) {}

    public function execute(): array
    {
        $persons = PeopleListCache::make(
            accountId: $this->user->account_id,
        )->value();

        $currentYear = date('Y');
        $previousYear = (int) $currentYear - 1;

        $encounters = [
            'currentYearCount' => $this->person->encounters()
                ->whereYear('seen_at', $currentYear)
                ->count(),
            'previousYearCount' => $this->person->encounters()
                ->whereYear('seen_at', $previousYear)
                ->count(),
            'latestSeen' => $this->person->encounters()
                ->orderBy('seen_at', 'desc')
                ->take(5)
                ->get(),
        ];

        return [
            'person' => $this->person,
            'persons' => $persons,
            'encounters' => $encounters,
        ];
    }
}
