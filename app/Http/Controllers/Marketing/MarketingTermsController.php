<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MarketingPage;

class MarketingTermsController extends Controller
{
    public function index()
    {
        return view('marketing.terms', [
            'marketingPage' => MarketingPage::first(),
            'viewName' => 'marketing.terms',
        ]);
    }
}
