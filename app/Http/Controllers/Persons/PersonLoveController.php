<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Enums\KidsStatusType;
use App\Enums\MaritalStatusType;
use App\Http\Controllers\Controller;
use App\Services\CreateLoveRelationship;
use App\Services\CreatePerson;
use App\Services\DestroyLoveRelationship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonLoveController extends Controller
{
    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.family.partials.love.new', [
            'person' => $person,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'first_name' => 'required|string|min:3|max:100',
            'last_name' => 'nullable|string|min:3|max:100',
            'nature_of_relationship' => 'required|string|min:3|max:100',
        ]);

        $isActive = $request->input('active') === 'active';
        $isEntryCreated = $request->input('create_entry') === 'create_entry';

        $newPerson = (new CreatePerson(
            user: Auth::user(),
            gender: null,
            maritalStatus: MaritalStatusType::COUPLE->value,
            kidsStatus: KidsStatusType::UNKNOWN->value,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'] ?? null,
            middleName: null,
            nickname: null,
            suffix: null,
            prefix: null,
            maidenName: null,
            canBeDeleted: true,
            isListed: $isEntryCreated,
        ))->execute();

        (new CreateLoveRelationship(
            user: Auth::user(),
            person: $person,
            relatedPerson: $newPerson,
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
