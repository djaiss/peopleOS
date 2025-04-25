<?php

declare(strict_types=1);

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use App\Services\GetEntryData;
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

        $viewData = (new GetEntryData(
            user: Auth::user(),
            day: $day,
            month: $month,
            year: $year,
        ))->execute();

        return view('journal.entry.show', $viewData);
    }
}
