<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Encounter;
use App\Services\CreateEncounter;
use App\Services\DestroyEncounter;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonEncounterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'seen_at' => 'required|date',
        ]);

        (new CreateEncounter(
            user: Auth::user(),
            person: $person,
            seenAt: Carbon::parse($validated['seen_at']),
            context: null,
        ))->execute();

        $person->encounters_shown = true;
        $person->save();

        return redirect()->route('persons.show', $person->slug)
            ->with('status', trans('Encounter reported'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $encounter = Encounter::where('person_id', $person->id)
            ->findOrFail($request->route()->parameter('encounter'));

        (new DestroyEncounter(
            user: Auth::user(),
            encounter: $encounter,
        ))->execute();

        return redirect()->route('persons.show', $person->slug)
            ->with('status', trans('Encounter deleted'));
    }
}
