<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MarketingPage;
use App\Models\User;

class MarkMarketingPageAsUseful
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingPage $marketingPage,
    ) {}

    public function execute(): void
    {
        $this->user->marketingPages()->attach($this->marketingPage->id, [
            'helpful' => true,
        ]);
    }
}
