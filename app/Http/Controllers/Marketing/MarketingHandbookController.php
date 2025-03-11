<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Helpers\MarketingHelper;

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
}
