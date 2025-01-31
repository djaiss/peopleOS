<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Cache\PeopleListCache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonWorkController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PeopleListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        return view('persons.work.index', [
            'persons' => $persons,
            'person' => $person,
        ]);
    }
}
