<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Cache\PeopleListCache;
use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Person;
use App\Services\CreatePerson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function index()
    {
        $personsQuery = Person::where('account_id', Auth::user()->account_id)
            ->with('howWeMetSpecialDate')
            ->where('is_listed', true)
            ->orderBy('first_name')
            ->get();

        $persons = $personsQuery
            ->map(fn (Person $person): array => [
                'id' => $person->id,
                'name' => $person->name,
                'maiden_name' => $person->maiden_name,
                'nickname' => $person->nickname,
                'slug' => $person->slug,
                'avatar' => $person->getAvatar(64),
            ])
            ->sortBy('name');

        if (count($persons) === 0) {
            return view('persons.blank');
        }

        return redirect()->route('persons.show', [
            'slug' => $persons[0]['slug'],
        ]);
    }

    public function new(): View
    {
        $genders = Gender::where('account_id', Auth::user()->account_id)
            ->orderBy('position')
            ->get()
            ->map(fn (Gender $gender): array => [
                'id' => $gender->id,
                'name' => $gender->name,
            ]);

        return view('persons.new', [
            'genders' => $genders,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gender_id' => 'nullable|exists:genders,id',
            'marital_status' => ['required', 'string', 'in:unknown,single,in-relationship'],
            'kids_status' => ['required', 'string', 'in:unknown,no-kids,has-kids'],
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'is_listed' => 'boolean',
        ]);

        $person = (new CreatePerson(
            user: Auth::user(),
            gender: isset($validated['gender_id']) ? Gender::find($validated['gender_id']) : null,
            maritalStatus: $validated['marital_status'],
            kidsStatus: $validated['kids_status'],
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            nickname: $validated['nickname'],
            middleName: $validated['middle_name'],
            maidenName: $validated['maiden_name'],
            prefix: $validated['prefix'],
            suffix: $validated['suffix'],
            isListed: true,
        ))->execute();

        return redirect()->route('persons.show', [
            'slug' => $person->slug,
        ])->with('status', trans('The person has been created'));
    }

    public function show(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PeopleListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        $currentYear = date('Y');
        $previousYear = (int) $currentYear - 1;

        $encounters = [
            'currentYearCount' => $person->encounters()
                ->whereYear('seen_at', $currentYear)
                ->count(),
            'previousYearCount' => $person->encounters()
                ->whereYear('seen_at', $previousYear)
                ->count(),
            'latestSeen' => $person->encounters()
                ->orderBy('seen_at', 'desc')
                ->take(5)
                ->get(),
        ];

        return view('persons.show', [
            'person' => $person,
            'persons' => $persons,
            'encounters' => $encounters,
        ]);
    }
}
