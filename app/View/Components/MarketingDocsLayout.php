<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MarketingDocsLayout extends Component
{
    public function __construct(
        public ?string $pageviews = '',
    ) {}

    public function render(): View
    {
        return view('layouts.docs', [
            'pageviews' => $this->pageviews,
        ]);
    }
}
