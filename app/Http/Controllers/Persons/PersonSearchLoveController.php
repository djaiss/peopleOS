<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Helpers\RelationshipHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersonSearchLoveController extends Controller
{
    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.family.partials.love.search', [
            'person' => $person,
            'searchQuery' => '',
            'searchResults' => null,
        ]);
    }

    public function search(Request $request): View
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'search' => 'required|string|min:0|max:100',
        ]);

        $searchResults = RelationshipHelper::searchPerson(
            accountId: $person->account_id,
            name: $validated['search'],
            personId: $person->id,
        );

        return view('persons.family.partials.love.search', [
            'person' => $person,
            'searchQuery' => $validated['search'],
            'searchResults' => $searchResults,
        ]);
    }
}
