<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\MarketingTestimony;
use App\Services\CreateMarketingTestimony;
use App\Services\DestroyMarketingTestimony;
use App\Services\UpdateMarketingTestimony;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationMarketingTestimonialController extends Controller
{
    public function new(): View
    {
        return view('administration.marketing.partials.add-testimony');
    }

    public function create(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'testimony' => 'required|string|min:3|max:1000',
            'url_to_point_to' => 'nullable|url|max:255',
        ]);

        (new CreateMarketingTestimony(
            user: Auth::user(),
            nameToDisplay: $validated['name'],
            testimony: $validated['testimony'],
            urlToPointTo: $validated['url_to_point_to'] ?? null,
        ))->execute();

        return redirect()->route('administration.marketing.index')
            ->with('status', __('Changes saved'));
    }

    public function edit(Request $request): View
    {
        $id = (int) $request->route()->parameter('testimonial');

        $testimonial = MarketingTestimony::where('account_id', Auth::user()->account_id)
            ->where('id', $id)
            ->firstOrFail();

        return view('administration.marketing.partials.edit-testimony', [
            'testimonial' => $testimonial,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $id = (int) $request->route()->parameter('testimonial');

        $testimonial = MarketingTestimony::where('account_id', Auth::user()->account_id)
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'testimony' => 'required|string|min:3|max:255',
            'url_to_point_to' => 'nullable|url|max:255',
        ]);

        (new UpdateMarketingTestimony(
            user: Auth::user(),
            testimonyObject: $testimonial,
            nameToDisplay: $validated['name'],
            testimony: $validated['testimony'],
            urlToPointTo: $validated['url_to_point_to'] ?? null,
        ))->execute();

        return redirect()->route('administration.marketing.index')
            ->with('status', __('Changes saved'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $id = (int) $request->route()->parameter('testimonial');

        $testimonial = MarketingTestimony::where('account_id', Auth::user()->account_id)
            ->where('id', $id)
            ->firstOrFail();

        (new DestroyMarketingTestimony(
            user: Auth::user(),
            testimony: $testimonial,
        ))->execute();

        return redirect()->route('administration.marketing.index')
            ->with('status', __('Changes saved'));
    }
}
