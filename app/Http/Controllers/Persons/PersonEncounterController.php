<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Encounter;
use App\Services\CreateEncounter;
use App\Services\DestroyEncounter;
use App\Services\UpdateEncounter;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonEncounterController extends Controller
{
    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.overview.partials.add-encounter', [
            'person' => $person,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'seen_at' => 'required|date',
            'context' => 'nullable|string',
        ]);

        (new CreateEncounter(
            user: Auth::user(),
            person: $person,
            seenAt: Carbon::parse($validated['seen_at']),
            context: $validated['context'] ?? null,
        ))->execute();

        $person->encounters_shown = true;
        $person->save();

        return redirect()->route('persons.show', $person->slug)
            ->with('status', trans('Encounter reported'));
    }

    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');
        $encounter = Encounter::where('person_id', $person->id)
            ->findOrFail($request->route()->parameter('encounter'));

        return view('persons.overview.partials.edit-encounter', [
            'person' => $person,
            'encounter' => $encounter,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $encounter = Encounter::where('person_id', $person->id)
            ->findOrFail($request->route()->parameter('encounter'));

        $validated = $request->validate([
            'seen_at' => 'required|date',
            'context' => 'nullable|string',
        ]);

        (new UpdateEncounter(
            user: Auth::user(),
            person: $person,
            encounter: $encounter,
            seenAt: Carbon::parse($validated['seen_at']),
            context: $validated['context'],
        ))->execute();

        return redirect()->route('persons.show', $person->slug)
            ->with('status', trans('Encounter updated'));
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
