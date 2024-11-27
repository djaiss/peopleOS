<?php

namespace App\Http\ViewModels\Settings\Personalization;

use App\Models\Account;
use App\Models\MaritalStatus;
use Illuminate\Support\Collection;

class MaritalStatusViewModel
{
    /**
     * Get all the marital statuses in the account.
     */
    public static function index(Account $account): Collection
    {
        $maritalStatuses = $account->maritalStatuses()
            ->get()
            ->map(fn (MaritalStatus $maritalStatus) => self::maritalStatus($maritalStatus));

        return $maritalStatuses;
    }

    /**
     * Get the detail of a single marital status.
     */
    public static function maritalStatus(MaritalStatus $maritalStatus): array
    {
        return [
            'id' => $maritalStatus->id,
            'label' => $maritalStatus->getLabel(),
        ];
    }
}
