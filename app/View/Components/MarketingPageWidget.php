<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Helpers\MarketingHelper;
use App\Models\MarketingPage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class MarketingPageWidget extends Component
{
    public ?bool $findHelpful = null;

    public ?string $votedAt = null;

    public ?string $comment = null;

    public ?string $lastModified = null;

    public function __construct(
        public MarketingPage $marketingPage,
        public string $viewName,
    ) {}

    public function render(): View
    {
        $this->getMarketingData();

        $this->lastModified = MarketingHelper::getLastModified($this->viewName)
            ->format('F j, Y');

        return view('components.marketing.marketing-page-widget');
    }

    private function getMarketingData(): void
    {
        if (Auth::check()) {
            $userMarketingPage = Auth::user()->marketingPages()
                ->where('marketing_page_id', $this->marketingPage->id)
                ->first();

            if ($userMarketingPage) {
                $this->findHelpful = $userMarketingPage->pivot->helpful;
                $this->votedAt = $userMarketingPage->pivot->created_at->format('F j, Y');
                $this->comment = $userMarketingPage->pivot->comment ?? null;
            }
        }

    }
}
