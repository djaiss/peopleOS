<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Services\UpdatePersonFoodAllergy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonAllergiesFoodController extends Controller
{
    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');

        $personsCollection = collect();
        $personsCollection->push($person);
        foreach ($person->getActivePartnersAsPersonCollection() as $partner) {
            $personsCollection->push($partner);
        }

        return view('persons.food.partials.allergies.edit', [
            'person' => $person,
            'persons' => $personsCollection,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');
        $user = Auth::user();

        // Validate all person allergies fields
        $validated = $request->validate([
            'person_allergies' => 'array',
            'person_allergies.*' => 'nullable|string|max:255',
        ]);

        if (isset($validated['person_allergies']) && is_array($validated['person_allergies'])) {
            foreach ($validated['person_allergies'] as $personId => $allergies) {
                // Find the person by ID
                $targetPerson = Person::find($personId);

                (new UpdatePersonFoodAllergy(
                    user: $user,
                    person: $targetPerson,
                    name: $allergies ?? '',
                ))->execute();
            }
        }

        return redirect()->route('person.food.index', $person->slug)
            ->with('status', trans('Changes saved'));
    }
}
