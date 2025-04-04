<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\MarketingPage;
use App\Services\DestroyMarketingVote;
use App\Services\GetMarketingActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdministrationMarketingController extends Controller
{
    public function index(): View
    {
        $viewData = (new GetMarketingActivities(
            user: Auth::user(),
        ))->execute();

        return view('administration.marketing.index', $viewData);
    }

    public function destroy(Request $request, MarketingPage $page): RedirectResponse
    {
        (new DestroyMarketingVote(
            user: Auth::user(),
            marketingPage: $page,
        ))->execute();

        return redirect()->route('administration.marketing.index');
    }
}
