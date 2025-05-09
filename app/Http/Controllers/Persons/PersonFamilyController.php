<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\GetRelationshipsListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Cache\PeopleListCache;

class PersonRelationshipController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PeopleListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        $viewData = (new GetRelationshipsListing(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return view('persons.family.index', [
            'persons' => $persons,
            'person' => $person,
            ...$viewData,
        ]);
    }
}
