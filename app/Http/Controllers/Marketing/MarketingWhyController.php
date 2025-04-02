<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketingWhyController extends Controller
{
    public function index(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.why.index', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }
}
