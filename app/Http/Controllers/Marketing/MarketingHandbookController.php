<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Helpers\MarketingHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketingHandbookController extends Controller
{
    public function index(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.company.handbook.index', [
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function project(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.project');

        return view('marketing.company.handbook.project', [
            'stats' => $stats,
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function principles(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.principles');

        return view('marketing.company.handbook.principles', [
            'stats' => $stats,
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function shipping(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.shipping');

        return view('marketing.company.handbook.shipping', [
            'stats' => $stats,
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function money(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.money');

        return view('marketing.company.handbook.money', [
            'stats' => $stats,
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function why(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.why-open-source');

        return view('marketing.company.handbook.why-open-source', [
            'stats' => $stats,
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function where(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.where');

        return view('marketing.company.handbook.where', [
            'stats' => $stats,
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }

    public function marketing(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.marketing');

        return view('marketing.company.handbook.marketing', [
            'stats' => $stats,
            'pageviews' => number_format($marketingPage->pageviews ?? 0),
        ]);
    }
}
