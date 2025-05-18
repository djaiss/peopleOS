<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PeopleListCache;
use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;

class GetWorkInformationListing
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
}
