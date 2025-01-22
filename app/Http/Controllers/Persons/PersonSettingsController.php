<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Person;
use App\Services\DestroyPerson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonSettingsController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = Person::where('account_id', Auth::user()->account_id)
            ->orderBy('first_name')
            ->get()
            ->map(fn (Person $person): array => [
                'id' => $person->id,
                'name' => $person->name,
                'slug' => $person->slug,
            ])
            ->sortBy('name');

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

    public function destroy(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        (new DestroyPerson(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return redirect()->route('persons.index')
            ->success(trans('Person deleted successfully'));
    }
}
