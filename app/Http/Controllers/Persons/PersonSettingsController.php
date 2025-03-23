<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Cache\PeopleListCache;
use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Services\DestroyPerson;
use App\Services\UpdatePerson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonSettingsController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PeopleListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        $genders = Gender::where('account_id', Auth::user()->account_id)
            ->get()
            ->map(fn (Gender $gender): array => [
                'id' => $gender->id,
                'name' => $gender->name,
            ]);

        return view('persons.settings.index', [
            'person' => $person,
            'persons' => $persons,
            'genders' => $genders,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'nullable|string|min:3|max:255',
            'middle_name' => 'nullable|string|min:3|max:255',
            'nickname' => 'nullable|string|min:3|max:255',
            'suffix' => 'nullable|string|min:3|max:255',
            'prefix' => 'nullable|string|min:3|max:255',
            'maiden_name' => 'nullable|string|min:3|max:255',
            'gender_id' => 'nullable|integer|exists:genders,id',
            'is_listed' => 'nullable|boolean',
        ]);

        $gender = Gender::find($validated['gender_id']);

        $person = (new UpdatePerson(
            user: Auth::user(),
            person: $person,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            middleName: $validated['middle_name'],
            nickname: $validated['nickname'],
            suffix: $validated['suffix'],
            prefix: $validated['prefix'],
            maidenName: $validated['maiden_name'],
            gender: $gender,
            maritalStatus: $person->marital_status,
            kidsStatus: $person->kids_status,
            canBeDeleted: $person->can_be_deleted,
            isListed: $person->is_listed,
        ))->execute();

        return redirect()->route('person.settings.index', $person->slug)
            ->with('status', trans('Person updated successfully'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        (new DestroyPerson(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return redirect()->route('person.index')
            ->with('status', trans('Person deleted successfully'));
    }
}
