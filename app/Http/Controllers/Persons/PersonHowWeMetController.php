<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\ToggleHowIMetVisibility;
use App\Services\UpdateHowIMetInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonHowWeMetController extends Controller
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
    public function create(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        (new ToggleHowIMetVisibility(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return redirect()->route('person.show', $person->slug);
    }

    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'how_we_met' => 'nullable|string',
            'how_we_met_location' => 'nullable|string',
            'how_we_met_first_impressions' => 'nullable|string',
            'how_we_met_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'how_we_met_month' => 'nullable|integer|min:0|max:12',
            'how_we_met_day' => 'nullable|integer|min:0|max:31',
        ]);

        $dateSet = $request->input('date') !== 'unknown';
        $reminderSet = $request->input('reminder') === 'reminded';

        (new UpdateHowIMetInformation(
            user: Auth::user(),
            person: $person,
            howIMet: $validated['how_we_met'],
            howIMetLocation: $validated['how_we_met_location'],
            howIMetFirstImpressions: $validated['how_we_met_first_impressions'],
            howIMetShown: $person->how_we_met_shown,
            howIMetYear: $dateSet ? (int) ($validated['how_we_met_year'] ?? null) : null,
            howIMetMonth: $dateSet ? (int) ($validated['how_we_met_month'] ?? null) : null,
            howIMetDay: $dateSet ? (int) ($validated['how_we_met_day'] ?? null) : null,
            addYearlyReminder: $reminderSet,
        ))->execute();

        return redirect()->route('person.show', $person->slug)
            ->with('status', trans('Changes saved'));
    }
}
