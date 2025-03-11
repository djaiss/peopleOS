<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Services\FetchMergedPRs;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function index(): View
    {
        $accountNumbers = Account::where('created_at', '>=', now()->subWeek())->count();

        $pullRequests = Cache::remember(
            key: 'github_pull_requests',
            ttl: now()->addHours(24),
            callback: fn (): mixed => (new FetchMergedPRs())->execute()
        );

        return view('marketing.index', [
            'accountNumbers' => $accountNumbers,
            'pullRequests' => $pullRequests,
        ]);
    }
}
