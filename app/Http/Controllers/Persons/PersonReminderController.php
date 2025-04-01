<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Services\GetRemindersListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonReminderController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $viewData = (new GetRemindersListing(
            user: Auth::user(),
            person: $person,
        ))->execute();

        return view('persons.reminders.index', $viewData);
    }
}
