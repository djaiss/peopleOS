<?php

declare(strict_types=1);

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(): View
    {
        return view('journal.index');
    }
}
