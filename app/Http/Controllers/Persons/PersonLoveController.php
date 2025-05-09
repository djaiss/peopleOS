<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\GetRelationshipsListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Cache\PeopleListCache;

class PersonLoveController extends Controller
{
    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.family.partials.new-love-relationship', [
            'person' => $person,
        ]);
    }
}
