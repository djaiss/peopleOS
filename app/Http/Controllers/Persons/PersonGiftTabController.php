<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Services\UpdatePersonGiftTab;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * This controller is used to handle saving the gift tab for a person.
 * It is used when a user clicks on the gift tab (ideas, received, offered) for a person.
 */
class PersonGiftTabController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $giftStatus = $request->route()->parameter('status');

        (new UpdatePersonGiftTab(
            user: Auth::user(),
            person: $person,
            status: $giftStatus,
        ))->execute();

        return redirect()->route('persons.gifts.index', $person->slug);
    }
}
