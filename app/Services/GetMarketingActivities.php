<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MarketingPage;
use App\Models\User;

class GetMarketingActivities
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function execute(): array
    {
        $marketingPages = $this->user->marketingPages()
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(fn (MarketingPage $marketingPage): array => [
                'id' => $marketingPage->id,
                'url' => $marketingPage->url,
                'helpful' => $marketingPage->pivot->helpful,
                'comment' => $marketingPage->pivot->comment,
                'voted_at' => $marketingPage->pivot->updated_at->setTimezone($this->user->timezone)->format('Y-m-d H:i'),
            ]);

        return [
            'marketingPages' => $marketingPages,
        ];
    }
}
