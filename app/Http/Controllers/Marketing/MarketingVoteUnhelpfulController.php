<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MarketingPage;
use App\Services\MarkMarketingPageAsUnhelpful;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MarketingVoteUnhelpfulController extends Controller
{
    public function update(Request $request, MarketingPage $page): RedirectResponse
    {
        (new MarkMarketingPageAsUnhelpful(
            user: Auth::user(),
            marketingPage: $page
        ))->execute();

        return redirect()->back()->with('hasVoted', true);
    }
}
