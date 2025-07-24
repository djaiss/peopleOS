<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MarketingPage;
use Illuminate\View\View;

class MarketingTermsController extends Controller
{
    public function index(): View
    {
        return view('marketing.terms', [
            'marketingPage' => MarketingPage::first(),
            'viewName' => 'marketing.terms',
        ]);
    }
}
