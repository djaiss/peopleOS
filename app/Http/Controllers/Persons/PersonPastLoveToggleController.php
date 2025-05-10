<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\TogglePastLoveRelationshipsVisibility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonPastLoveToggleController extends Controller
{
    /**
     * This is just used to update the past love relationships toggle.
     */
    public function create(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        (new TogglePastLoveRelationshipsVisibility(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return redirect()->route('person.family.index', $person->slug);
    }
}
