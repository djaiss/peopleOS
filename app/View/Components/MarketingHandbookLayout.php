<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\MarketingPage;
use Illuminate\View\Component;
use Illuminate\View\View;

class MarketingHandbookLayout extends Component
{
    public function __construct(
        public MarketingPage $marketingPage,
        public string $viewName,
    ) {}

    public function render(): View
    {
        return view('layouts.handbook', [
            'marketingPage' => $this->marketingPage,
            'viewName' => $this->viewName,
        ]);
    }
}
