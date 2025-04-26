<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Enums\AgeType;
use App\Http\Controllers\Controller;
use App\Services\UpdateAgeOfAPerson;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonSettingsAgeController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'age' => ['required', 'string', 'in:exact,estimated,unknown'],
            'estimated_age' => 'nullable|integer|min:0|max:120',
            'birthdate' => 'nullable|date_format:Y-m-d',
        ]);

        if ($validated['age'] !== AgeType::UNKNOWN) {
            $year = array_key_exists('birthdate', $validated) ? Carbon::parse($validated['birthdate'])->year : null;
            $month = array_key_exists('birthdate', $validated) ? Carbon::parse($validated['birthdate'])->month : null;
            $day = array_key_exists('birthdate', $validated) ? Carbon::parse($validated['birthdate'])->day : null;

            (new UpdateAgeOfAPerson(
                user: Auth::user(),
                person: $person,
                ageType: $validated['age'],
                estimatedAge: array_key_exists('estimated_age', $validated) ? (int) $validated['estimated_age'] : null,
                ageBracket: null,
                ageYear: $year,
                ageMonth: $month,
                ageDay: $day,
                addYearlyReminder: false,
            ))->execute();
        }

        return redirect()->route('person.settings.index', ['slug' => $person->slug])
            ->with('status', trans('Changes saved'));
    }
}
