<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MarketingLayout extends Component
{
    public function __construct(
        public ?string $pageviews = '',
    ) {}

    public function render(): View
    {
        return view('layouts.marketing', [
            'pageviews' => $this->pageviews,
        ]);
    }
}
