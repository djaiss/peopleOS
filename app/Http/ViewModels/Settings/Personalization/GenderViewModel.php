<?php

namespace App\Http\ViewModels\Settings\Personalization;

use App\Models\Account;
use App\Models\Gender;
use Illuminate\Support\Collection;

class GenderViewModel
{
    /**
     * Get all the genders in the account.
     */
    public static function index(Account $account): Collection
    {
        $genders = $account->genders()
            ->orderBy('position', 'asc')
            ->get()
            ->map(fn (Gender $gender) => self::gender($gender));

        return $genders;
    }

    /**
     * Get the detail of a single gender.
     */
    public static function gender(Gender $gender): array
    {
        return [
            'id' => $gender->id,
            'label' => $gender->getLabel(),
            'position' => $gender->position,
        ];
    }
}
