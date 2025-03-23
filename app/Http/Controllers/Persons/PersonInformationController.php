<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\UpdatePersonInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonInformationController extends Controller
{
    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.overview.partials.edit-information', [
            'person' => $person,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'timezone' => ['nullable', 'string', 'timezone:all'],
            'nationalities' => ['nullable', 'string'],
            'languages' => ['nullable', 'string'],
        ]);

        (new UpdatePersonInformation(
            user: Auth::user(),
            person: $person,
            timezone: $validated['timezone'],
            nationalities: $validated['nationalities'],
            languages: $validated['languages'],
        ))->execute();

        return redirect()->route('person.show', $person->slug)
            ->with('status', trans('Changes saved'));
    }
}
