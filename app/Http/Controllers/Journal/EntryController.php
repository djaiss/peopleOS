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
        $entry = $request->attributes->get('entry');

        $viewData = (new GetEntryData(
            user: Auth::user(),
            entry: $entry,
        ))->execute();

        return view('journal.entry.show', $viewData);
    }
}
