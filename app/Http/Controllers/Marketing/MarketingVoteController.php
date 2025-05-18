<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MarketingPage;
use App\Services\DestroyMarketingVote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingVoteController extends Controller
{
    public function update(Request $request, MarketingPage $page): RedirectResponse
    {
        (new DestroyMarketingVote(
            user: Auth::user(),
            marketingPage: $page,
        ))->execute();

        return redirect()->back();
    }
}
