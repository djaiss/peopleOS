<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Cache\PersonsListCache;
use App\Http\Controllers\Controller;
use App\Services\GetRelationshipsListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonRelationshipController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PersonsListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        $viewData = (new GetRelationshipsListing(
            person: $person,
        ))->execute();

        return view('persons.family.index', [
            'persons' => $persons,
            'person' => $person,
            ...$viewData,
        ]);
    }
}
