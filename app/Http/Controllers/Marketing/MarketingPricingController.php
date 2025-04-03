<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketingPricingController extends Controller
{
    public function index(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.pricing.index', [
            'marketingPage' => $marketingPage,
        ]);
    }
}
