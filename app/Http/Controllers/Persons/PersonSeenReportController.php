<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\PersonSeenReport;
use App\Services\CreatePersonSeenReport;
use App\Services\DestroyPersonSeenReport;
use App\Services\ToggleHowIMetVisibility;
use App\Services\TogglePersonSeenReportListVisibility;
use App\Services\UpdateHowIMetInformation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonSeenReportController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'seen_at' => 'required|date',
        ]);

        (new CreatePersonSeenReport(
            user: Auth::user(),
            person: $person,
            seenAt: Carbon::parse($validated['seen_at']),
            periodOfTime: null,
        ))->execute();

        $person->encounters_shown = true;
        $person->save();

        return redirect()->route('persons.show', $person->slug)
            ->with('status', trans('Encounter reported'));
    }

    public function edit(Request $request, Person $person, PersonSeenReport $encounter): View
    {
        $person = $request->attributes->get('person');

        if ($person->account_id !== Auth::user()->account_id) {
            abort(403);
        }

        return view('persons.encounters.edit', [
            'person' => $person,
            'encounter' => $encounter,
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $encounter = PersonSeenReport::where('person_id', $person->id)
            ->findOrFail($request->route()->parameter('encounter'));

        (new DestroyPersonSeenReport(
            user: Auth::user(),
            personSeenReport: $encounter,
        ))->execute();

        return redirect()->route('persons.show', $person->slug)
            ->with('status', trans('Encounter deleted'));
    }
}
