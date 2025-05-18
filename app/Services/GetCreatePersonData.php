<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Gender;
use App\Models\User;

class GetCreatePersonData
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function execute(): array
    {
        $genders = Gender::where('account_id', $this->user->account_id)
            ->orderBy('position')
            ->get()
            ->map(fn(Gender $gender): array => [
                'id' => $gender->id,
                'name' => $gender->name,
            ]);

        return [
            'genders' => $genders,
        ];
    }
}
