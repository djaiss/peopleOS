<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Helpers\MarketingHelper;
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
        $stats = MarketingHelper::getStats('marketing.company.handbook.project');

        return view('marketing.company.handbook.project', [
            'stats' => $stats,
        ]);
    }

    public function principles(): View
    {
        $stats = MarketingHelper::getStats('marketing.company.handbook.principles');

        return view('marketing.company.handbook.principles', [
            'stats' => $stats,
        ]);
    }

    public function shipping(): View
    {
        $stats = MarketingHelper::getStats('marketing.company.handbook.shipping');

        return view('marketing.company.handbook.shipping', [
            'stats' => $stats,
        ]);
    }

    public function money(): View
    {
        $stats = MarketingHelper::getStats('marketing.company.handbook.money');

        return view('marketing.company.handbook.money', [
            'stats' => $stats,
        ]);
    }

    public function why(): View
    {
        $stats = MarketingHelper::getStats('marketing.company.handbook.why-open-source');

        return view('marketing.company.handbook.why-open-source', [
            'stats' => $stats,
        ]);
    }

    public function where(): View
    {
        $stats = MarketingHelper::getStats('marketing.company.handbook.where');

        return view('marketing.company.handbook.where', [
            'stats' => $stats,
        ]);
    }

    public function marketing(): View
    {
        $stats = MarketingHelper::getStats('marketing.company.handbook.marketing');

        return view('marketing.company.handbook.marketing', [
            'stats' => $stats,
        ]);
    }
}
