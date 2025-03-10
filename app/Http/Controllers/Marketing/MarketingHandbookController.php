<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MarketingHandbookController extends Controller
{
    public function index(): View
    {
        return view('marketing.company.handbook.index');
    }

    public function project(): View
    {
        return view('marketing.company.handbook.project');
    }
}
