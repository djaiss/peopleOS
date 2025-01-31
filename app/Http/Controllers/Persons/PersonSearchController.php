<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PersonSearchController extends Controller
{
    public function store(Request $request): View
    {
        $validated = $request->validate([
            'term' => 'required|string|max:255',
        ]);

        $persons = Person::where('account_id', Auth::user()->account_id)
            ->where('is_listed', true)
            ->orderBy('first_name')
            ->get()
            ->map(fn (Person $person): array => [
                'id' => $person->id,
                'name' => $person->name,
                'maiden_name' => $person->maiden_name,
                'nickname' => $person->nickname,
                'slug' => $person->slug,
            ])
            ->sortBy('name');

        $filteredPersons = $persons->filter(function (array $personItem) use ($validated): bool {
            if ($validated['term'] === '' || $validated['term'] === '0') {
                return true;
            }
            if (Str::contains(mb_strtolower((string) $personItem['name']), mb_strtolower((string) $validated['term']))) {
                return true;
            }
            if (Str::contains(mb_strtolower((string) $personItem['nickname']), mb_strtolower((string) $validated['term']))) {
                return true;
            }

            return Str::contains(mb_strtolower((string) $personItem['maiden_name']), mb_strtolower((string) $validated['term']));
        });

        return view('persons.partials.persons-list', [
            'persons' => $filteredPersons,
            'person' => $request->attributes->get('person'),
        ]);
    }
}
