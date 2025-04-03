<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MarketingPage;
use App\Services\MarkMarketingPageAsUseful;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MarketingVoteUsefulController extends Controller
{
    public function update(Request $request, MarketingPage $marketingPage): RedirectResponse
    {
        (new MarkMarketingPageAsUseful(
            user: $request->user(),
            marketingPage: $marketingPage
        ))->execute();

        return redirect()->back()->with('hasVoted', true);
    }
}
