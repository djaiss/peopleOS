<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Services\CreateChild;
use App\Services\CreatePet;
use App\Services\DestroyChild;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonPetController extends Controller
{
    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.family.partials.pets.new', [
            'person' => $person,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
        ]);

        (new CreatePet(
            user: Auth::user(),
            account: $person->account,
            person: $person,
            name: $validated['name'],
            species: $validated['species'],
            breed: $validated['breed'],
            gender: $validated['gender'],
        ))->execute();

        return redirect()->route('person.family.index', $person)
            ->with('status', trans('Changes saved'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $child = $request->attributes->get('child');

        (new DestroyChild(
            user: Auth::user(),
            child: $child,
        ))->execute();

        return redirect()->route('person.family.index', $child->parent)
            ->with('status', trans('Changes saved'));
    }
}
