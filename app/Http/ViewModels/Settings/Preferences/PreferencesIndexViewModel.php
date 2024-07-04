<?php

namespace App\Http\ViewModels\Settings\Preferences;

use App\Helpers\NameHelper;
use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;

class PreferencesIndexViewModel
{
    public static function data(User $user): array
    {
        return [
            'name_order' => self::nameOrder($user),
        ];
    }

    public static function nameOrder(User $user): array
    {
        $contact = new Contact([
            'first_name' => 'James',
            'last_name' => 'Bond',
            'nickname' => '007',
            'middle_name' => 'W.',
            'maiden_name' => 'Muller',
        ]);

        $nameExample = NameHelper::formatContactName($user, $contact);

        return [
            'name_example' => $nameExample,
            'name_order' => $user->name_order,
        ];
    }
}
