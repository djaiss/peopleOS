<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonFamilyController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = Person::where('account_id', Auth::user()->account_id)
            ->where('is_listed', true)
            ->get()
            ->map(fn (Person $person): array => [
                'id' => $person->id,
                'name' => $person->name,
                'maiden_name' => $person->maiden_name,
                'nickname' => $person->nickname,
                'slug' => $person->slug,
            ])
            ->sortBy('name');

        return view('persons.family.index', [
            'persons' => $persons,
            'person' => $person,
        ]);
    }
}
