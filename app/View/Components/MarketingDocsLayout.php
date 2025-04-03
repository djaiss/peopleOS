<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\MarketingPage;
use Illuminate\View\Component;
use Illuminate\View\View;

class MarketingDocsLayout extends Component
{
    public function __construct(
        public MarketingPage $marketingPage,
    ) {}

    public function render(): View
    {
        return view('layouts.docs', [
            'marketingPage' => $this->marketingPage,
        ]);
    }
}
