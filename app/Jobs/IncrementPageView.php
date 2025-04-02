<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\MarketingPage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class IncrementPageView implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MarketingPage $marketingPage,
    ) {}

    public function handle(): void
    {
        $this->marketingPage->increment('pageviews');
    }
}
