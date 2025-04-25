<?php

declare(strict_types=1);

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MonthController extends Controller
{
    public function show(Request $request): RedirectResponse
    {
        $year = (int) $request->route()->parameter('year');
        $month = (int) $request->route()->parameter('month');
        $day = 1;

        return redirect()->route('journal.entry.show', [
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ]);
    }
}
