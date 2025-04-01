<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Person;
use App\Services\CreatePerson;
use App\Services\GetCreatePersonData;
use App\Services\GetPersonDetails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function index()
    {
        $personsCount = Person::where('account_id', Auth::user()->account_id)
            ->count();

        if ($personsCount === 0) {
            return view('persons.blank');
        }

        if (Auth::user()->last_person_seen_id) {
            $person = Person::where('account_id', Auth::user()->account_id)
                ->where('id', Auth::user()->last_person_seen_id)
                ->select('slug')
                ->first();
        } else {
            $person = Person::where('account_id', Auth::user()->account_id)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        return redirect()->route('person.show', [
            'slug' => $person->slug,
        ]);
    }

    public function new(): View
    {
        $viewData = (new GetCreatePersonData(
            user: Auth::user(),
        ))->execute();

        return view('persons.new', $viewData);
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

        return redirect()->route('person.show', [
            'slug' => $person->slug,
        ])->with('status', trans('The person has been created'));
    }

    public function show(Request $request): View
    {
        $person = $request->attributes->get('person');

        $viewData = (new GetPersonDetails(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return view('persons.show', $viewData);
    }
}
