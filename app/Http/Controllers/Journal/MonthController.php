<?php

declare(strict_types=1);

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use App\Services\GetEntryData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
