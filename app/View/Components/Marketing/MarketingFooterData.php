<?php

declare(strict_types=1);

namespace App\View\Components\Marketing;

use App\Helpers\MarketingHelper;
use App\Models\MarketingPage;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarketingFooterData extends Component
{
    public ?string $lastModified = null;

    public ?string $pageviews = null;

    public function __construct(
        public MarketingPage $marketingPage,
        public string $viewName,
    ) {}

    public function render(): View
    {
        $this->lastModified = MarketingHelper::getLastModified($this->viewName)
            ->format('F j, Y');

        $this->pageviews = number_format($this->marketingPage->pageviews ?? 0);

        return view('components.marketing.marketing-footer-data');
    }
}
