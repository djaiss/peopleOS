<?php

declare(strict_types=1);

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Services\CreateOrRetrieveEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EntryController extends Controller
{
    public function show(Request $request): View
    {
        $day = (int) $request->route()->parameter('day');
        $month = (int) $request->route()->parameter('month');
        $year = (int) $request->route()->parameter('year');

        // get the first journal in the account
        // currently, there is only one journal per account even though the
        // account can have multiple journals
        $journal = Journal::where('account_id', Auth::user()->account_id)->first();

        $entry = (new CreateOrRetrieveEntry(
            user: Auth::user(),
            journal: $journal,
            day: $day,
            month: $month,
            year: $year,
        ))->execute();

        return view('journal.show', [
            'entry' => $entry,
        ]);
    }
}
