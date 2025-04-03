<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MarketingPage;
use App\Services\MarkMarketingPageAsUnuseful;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MarketingVoteUnusefulController extends Controller
{
    public function update(Request $request, MarketingPage $marketingPage): RedirectResponse
    {
        (new MarkMarketingPageAsUnuseful(
            user: $request->user(),
            marketingPage: $marketingPage
        ))->execute();

        return redirect()->back();
    }
}
