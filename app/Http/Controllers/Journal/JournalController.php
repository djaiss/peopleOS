<?php

declare(strict_types=1);

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(): RedirectResponse
    {
        // get the current day
        now();
        $day = (int) now()->format('d');
        $month = (int) now()->format('m');
        $year = (int) now()->format('Y');

        return redirect()->route('journal.entry.show', [
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ]);
    }
}
