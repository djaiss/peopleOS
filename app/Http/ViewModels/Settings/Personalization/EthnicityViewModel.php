<?php

namespace App\Http\ViewModels\Settings\Personalization;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Ethnicity;
use App\Models\Note;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EthnicityViewModel
{
    /**
     * Get all the ethnicities in the account.
     */
    public static function index(Account $account): Collection
    {
        $ethnicities = $account->ethnicities()
            ->get()
            ->map(fn(Ethnicity $ethnicity) => self::ethnicity($ethnicity));

        return $ethnicities;
    }

    /**
     * Get the detail of a single gender.
     */
    public static function ethnicity(Ethnicity $ethnicity): array
    {
        return [
            'id' => $ethnicity->id,
            'label' => $ethnicity->getLabel(),
        ];
    }
}
