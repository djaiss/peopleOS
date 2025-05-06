<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Enums\UserWaitlistStatus;
use App\Http\Controllers\Controller;
use App\Models\AccountDeletionReason;
use App\Models\UserWaitlist;
use Illuminate\View\View;

class InstanceWaitlistController extends Controller
{
    public function index(): View
    {
        $subscribedAndConfirmed = UserWaitlist::where('status', UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(UserWaitlist $userWaitlist): array => $this->getUserWaitlist($userWaitlist));

        $counts = $this->getCount();

        return view('instance.waitlist.index', [
            'waitlist_entries' => $subscribedAndConfirmed,
            'title' => __('Subscribed and confirmed'),
            ...$counts,
        ]);
    }

    public function notConfirmed(): View
    {
        $subscribedNotConfirmed = UserWaitlist::where('status', UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(UserWaitlist $userWaitlist): array => $this->getUserWaitlist($userWaitlist));

        $counts = $this->getCount();

        return view('instance.waitlist.index', [
            'waitlist_entries' => $subscribedNotConfirmed,
            'title' => __('Subscribed but not confirmed'),
            ...$counts,
        ]);
    }

    public function approved(): View
    {
        $approved = UserWaitlist::where('status', UserWaitlistStatus::APPROVED->value)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(UserWaitlist $userWaitlist): array => $this->getUserWaitlist($userWaitlist));

        $counts = $this->getCount();

        return view('instance.waitlist.index', [
            'waitlist_entries' => $approved,
            'title' => __('Approved waitlist entries'),
            ...$counts,
        ]);
    }

    public function rejected(): View
    {
        $rejected = UserWaitlist::where('status', UserWaitlistStatus::REJECTED->value)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(UserWaitlist $userWaitlist): array => $this->getUserWaitlist($userWaitlist));

        $counts = $this->getCount();

        return view('instance.testimonials.index', [
            'waitlist_entries' => $rejected,
            'title' => __('Rejected waitlist entries'),
            ...$counts,
        ]);
    }

    public function all(): View
    {
        $waitlistEntries = UserWaitlist::orderBy('created_at', 'desc')
            ->get()
            ->map(fn(UserWaitlist $userWaitlist): array => $this->getUserWaitlist($userWaitlist));

        $counts = $this->getCount();

        return view('instance.testimonials.index', [
            'waitlist_entries' => $waitlistEntries,
            'title' => __('All waitlist entries'),
            ...$counts,
        ]);
    }

    public function getCount(): array
    {
        $subscribedAndConfirmedCount = UserWaitlist::where('status', UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value)
            ->count();

        $subscribedNotConfirmedCount = UserWaitlist::where('status', UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value)
            ->count();

        $rejectedCount = UserWaitlist::where('status', UserWaitlistStatus::REJECTED->value)
            ->count();

        $approvedCount = UserWaitlist::where('status', UserWaitlistStatus::APPROVED->value)
            ->count();

        $allCount = UserWaitlist::count();

        return [
            'subscribed_and_confirmed_count' => $subscribedAndConfirmedCount,
            'subscribed_not_confirmed_count' => $subscribedNotConfirmedCount,
            'approved_count' => $approvedCount,
            'rejected_count' => $rejectedCount,
            'all_count' => $allCount,
        ];
    }

    public function getUserWaitlist(UserWaitlist $userWaitlist): array
    {
        return [
            'id' => $userWaitlist->id,
            'email' => $userWaitlist->email,
            'status' => $userWaitlist->status,
            'created_at' => $userWaitlist->created_at->format('Y-m-d H:i:s'),
            'confirmed_at' => $userWaitlist->confirmed_at?->format('Y-m-d H:i:s'),
        ];
    }
}
