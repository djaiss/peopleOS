<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Services\CreateLoveRelationship;
use App\Services\DestroyLoveRelationship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonExistingLoveController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'person_id' => 'required|exists:persons,id',
            'nature_of_relationship' => 'required|string|min:3|max:100',
        ]);

        $isActive = $request->input('active') === 'active';
        $relatedPerson = Person::find($validated['person_id']);

        (new CreateLoveRelationship(
            user: Auth::user(),
            person: $person,
            relatedPerson: $relatedPerson,
            type: $validated['nature_of_relationship'],
            isCurrent: $isActive,
            notes: null,
        ))->execute();

        return redirect()->route('person.family.index', $person->slug)
            ->with('status', __('Relationship created'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $loveRelationship = $request->attributes->get('loveRelationship');

        (new DestroyLoveRelationship(
            user: Auth::user(),
            loveRelationship: $loveRelationship,
        ))->execute();

        return redirect()->route('person.family.index', $person->slug)
            ->with('status', __('Relationship deleted'));
    }
}
