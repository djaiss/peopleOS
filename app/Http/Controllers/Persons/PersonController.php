<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Services\CreatePerson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function index(): View
    {
        return view('persons.index');
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

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gender_id' => 'nullable|exists:genders,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
        ]);

        $person = (new CreatePerson(
            user: Auth::user(),
            gender: isset($validated['gender_id']) ? Gender::find($validated['gender_id']) : null,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            nickname: $validated['nickname'],
            middleName: $validated['middle_name'],
            maidenName: $validated['maiden_name'],
            prefix: $validated['prefix'],
            suffix: $validated['suffix'],
        ))->execute();

        return redirect()->route('persons.show', [
            'slug' => $person->slug,
        ])->success(trans('The person has been created'));
    }

    public function show(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.show', [
            'person' => $person,
        ]);
    }
}
