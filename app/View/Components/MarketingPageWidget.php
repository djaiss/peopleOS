<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\MarketingPage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class MarketingPageWidget extends Component
{
    public function __construct(
        public MarketingPage $marketingPage,
    ) {}

    public function render(): View
    {
        $this->getMarketingData();

        return view('components.marketing.marketing-page-widget');
    }

    private function getMarketingData(): void
    {
        $rate = null;
        $ratingAt = null;
        $comment = null;

        if (Auth::check()) {

            $userMarketingPage = Auth::user()->marketingPages()
                ->where('marketing_page_id', $this->marketingPage->id)
                ->first();

            if ($userMarketingPage) {
                $rate = $userMarketingPage->pivot->helpful;
                $ratingAt = $userMarketingPage->pivot->created_at;
                $comment = $userMarketingPage->pivot->comment;
            }
        }

    }
}
