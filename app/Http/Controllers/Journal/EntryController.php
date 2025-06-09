<?php

declare(strict_types=1);

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use App\Services\GetEntryBlocks;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EntryController extends Controller
{
    public function show(Request $request): View
    {
        $entry = $request->attributes->get('entry');

        $viewData = (new GetEntryBlocks(
            entry: $entry,
        ))->execute();

        return view('journal.entry.show', $viewData);
    }
}
