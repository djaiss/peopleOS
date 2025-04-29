<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Enums\MarketingTestimonyStatus;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\MarketingTestimony;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstanceTestimonialsController extends Controller
{
    public function index(): View
    {
        $pendingTestimonials = MarketingTestimony::where('status', MarketingTestimonyStatus::PENDING)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (MarketingTestimony $testimonial): array => $this->getMarketingTestimonial($testimonial));

        $approvedTestimonialsCount = MarketingTestimony::where('status', MarketingTestimonyStatus::APPROVED)
            ->count();

        $rejectedTestimonialsCount = MarketingTestimony::where('status', MarketingTestimonyStatus::REJECTED)
            ->count();

        $allTestimonialsCount = MarketingTestimony::count();

        return view('instance.testimonials.index', [
            'pending_testimonials' => $pendingTestimonials,
            'approved_testimonials_count' => $approvedTestimonialsCount,
            'rejected_testimonials_count' => $rejectedTestimonialsCount,
            'all_testimonials_count' => $allTestimonialsCount,
        ]);
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
        ];
    }
}
