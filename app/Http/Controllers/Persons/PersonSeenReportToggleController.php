<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\TogglePersonSeenReportListVisibility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonSeenReportToggleController extends Controller
{
    /**
     * This is just used to update the how we met toggle.
     */
    public function store(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        (new TogglePersonSeenReportListVisibility(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return redirect()->route('persons.show', $person->slug);
    }
}
