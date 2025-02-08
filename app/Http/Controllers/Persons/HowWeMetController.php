<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\UpdateHowIMetInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HowWeMetController extends Controller
{
    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.overview.partials.edit', [
            'person' => $person,
        ]);
    }

    /**
     * This is just used to update the how we met toggle.
     */
    public function post(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        (new UpdateHowIMetInformation(
            user: Auth::user(),
            person: $person,
            howIMet: $person->how_we_met,
            howIMetLocation: $person->how_we_met_location,
            howIMetFirstImpressions: $person->how_we_met_first_impressions,
            howIMetShown: ! $person->how_we_met_shown,
        ))->execute();

        return redirect()->route('persons.show', $person->slug);
    }

    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'how_we_met' => 'nullable|string',
            'how_we_met_location' => 'nullable|string',
            'how_we_met_first_impressions' => 'nullable|string',
        ]);

        (new UpdateHowIMetInformation(
            user: Auth::user(),
            person: $person,
            howIMet: $validated['how_we_met'],
            howIMetLocation: $validated['how_we_met_location'],
            howIMetFirstImpressions: $validated['how_we_met_first_impressions'],
            howIMetShown: $person->how_we_met_shown,
        ))->execute();

        return redirect()->route('persons.show', $person->slug)
            ->with('status', trans('Changes saved'));
    }
}
