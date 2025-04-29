<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Enums\MarketingTestimonyStatus;
use App\Http\Controllers\Controller;
use App\Models\MarketingTestimony;
use App\Services\RejectMarketingTestimony;
use App\Services\ValidateMarketingTestimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InstanceTestimonialsController extends Controller
{
    public function index(): View
    {
        $pendingTestimonials = MarketingTestimony::where('status', MarketingTestimonyStatus::PENDING->value)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (MarketingTestimony $testimonial): array => $this->getMarketingTestimonial($testimonial));

        $counts = $this->getCount();

        return view('instance.testimonials.index', [
            'testimonials' => $pendingTestimonials,
            'title' => __('Pending testimonials'),
            ...$counts,
        ]);
    }

    public function approved(): View
    {
        $testimonials = MarketingTestimony::where('status', MarketingTestimonyStatus::APPROVED->value)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(MarketingTestimony $testimonial): array => $this->getMarketingTestimonial($testimonial));

        $counts = $this->getCount();

        return view('instance.testimonials.index', [
            'testimonials' => $testimonials,
            'title' => __('Approved testimonials'),
            ...$counts,
        ]);
    }

    public function rejected(): View
    {
        $testimonials = MarketingTestimony::where('status', MarketingTestimonyStatus::REJECTED->value)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(MarketingTestimony $testimonial): array => $this->getMarketingTestimonial($testimonial));

        $counts = $this->getCount();

        return view('instance.testimonials.index', [
            'testimonials' => $testimonials,
            'title' => __('Rejected testimonials'),
            ...$counts,
        ]);
    }

    public function all(): View
    {
        $testimonials = MarketingTestimony::with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(MarketingTestimony $testimonial): array => $this->getMarketingTestimonial($testimonial));

        $counts = $this->getCount();

        return view('instance.testimonials.index', [
            'testimonials' => $testimonials,
            'title' => __('All testimonials'),
            ...$counts,
        ]);
    }

    public function accept(Request $request): RedirectResponse
    {
        $id = (int) $request->route()->parameter('testimonial');

        $testimonial = MarketingTestimony::where('id', $id)
            ->firstOrFail();

        (new ValidateMarketingTestimony(
            user: Auth::user(),
            testimonial: $testimonial,
        ))->execute();

        return redirect()->back()
            ->with('status', __('Changes saved'));
    }

    public function edit(Request $request): View
    {
        $id = (int) $request->route()->parameter('testimonial');

        $testimonial = MarketingTestimony::where('id', $id)
            ->firstOrFail();

        return view('instance.testimonials.partials.reject', [
            'testimonial' => $testimonial,
        ]);
    }

    public function reject(Request $request): RedirectResponse
    {
        $id = (int) $request->route()->parameter('testimonial');

        $testimonial = MarketingTestimony::where('id', $id)
            ->firstOrFail();

        (new RejectMarketingTestimony(
            user: Auth::user(),
            testimonial: $testimonial,
            reason: $request->input('reason'),
        ))->execute();

        return redirect()->back()
            ->with('status', __('Changes saved'));
    }

    public function getCount(): array
    {
        $pendingTestimonialsCount = MarketingTestimony::where('status', MarketingTestimonyStatus::PENDING)
            ->count();

        $approvedTestimonialsCount = MarketingTestimony::where('status', MarketingTestimonyStatus::APPROVED)
            ->count();

        $rejectedTestimonialsCount = MarketingTestimony::where('status', MarketingTestimonyStatus::REJECTED)
            ->count();

        $allTestimonialsCount = MarketingTestimony::count();

        return [
            'pending_testimonials_count' => $pendingTestimonialsCount,
            'approved_testimonials_count' => $approvedTestimonialsCount,
            'rejected_testimonials_count' => $rejectedTestimonialsCount,
            'all_testimonials_count' => $allTestimonialsCount,
        ];
    }

    public function getMarketingTestimonial(MarketingTestimony $testimonial): array
    {
        return [
            'id' => $testimonial->id,
            'account_id' => $testimonial->account_id,
            'status' => $testimonial->status,
            'user' => [
                'id' => $testimonial->user->id,
                'name' => $testimonial->user->name,
            ],
            'name_to_display' => $testimonial->name_to_display,
            'url_to_point_to' => $testimonial->url_to_point_to,
            'testimony' => $testimonial->testimony,
            'created_at' => $testimonial->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
