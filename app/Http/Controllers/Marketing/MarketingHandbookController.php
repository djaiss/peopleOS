<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Helpers\MarketingHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * This controller is used to handle the marketing handbook pages.
 * It should be one of the only controllers that does not follow the naming convention
 * for methods in a controller.
 */
class MarketingHandbookController extends Controller
{
    public function index(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');

        return view('marketing.company.handbook.index', [
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.company.handbook.index',
        ]);
    }

    public function project(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.project');

        return view('marketing.company.handbook.project', [
            'stats' => $stats,
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.company.handbook.project',
        ]);
    }

    public function principles(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.principles');

        return view('marketing.company.handbook.principles', [
            'stats' => $stats,
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.company.handbook.principles',
        ]);
    }

    public function shipping(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.shipping');

        return view('marketing.company.handbook.shipping', [
            'stats' => $stats,
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.company.handbook.shipping',
        ]);
    }

    public function money(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.money');

        return view('marketing.company.handbook.money', [
            'stats' => $stats,
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.company.handbook.money',
        ]);
    }

    public function why(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.why-open-source');

        return view('marketing.company.handbook.why-open-source', [
            'stats' => $stats,
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.company.handbook.why-open-source',
        ]);
    }

    public function where(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.where');

        return view('marketing.company.handbook.where', [
            'stats' => $stats,
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.company.handbook.where',
        ]);
    }

    public function marketing(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.marketing');

        return view('marketing.company.handbook.marketing', [
            'stats' => $stats,
            'marketingPage' => $marketingPage,
            'viewName' => 'marketing.company.handbook.marketing',
        ]);
    }

    public function socialMedia(Request $request): View
    {
        $marketingPage = $request->attributes->get('marketingPage');
        $stats = MarketingHelper::getStats('marketing.company.handbook.social-media');

        return view('marketing.company.handbook.social-media', [
            'stats' => $stats,
            'marketingPage' => $marketingPage,
        ]);
    }
}
