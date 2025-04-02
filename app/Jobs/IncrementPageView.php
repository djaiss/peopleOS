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
        public string $url,
    ) {}

    public function handle(): void
    {
        $page = MarketingPage::where('url', $this->url)->firstOrCreate([
            'url' => $this->url,
        ]);

        if ($page) {
            $page->increment('pageviews');
        }
    }
}
