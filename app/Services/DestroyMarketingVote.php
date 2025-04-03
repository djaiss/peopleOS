<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MarketingPage;
use App\Models\User;

/**
 * This service is used to destroy a vote (helpful or unhelpful) on a marketing page.
 */
class DestroyMarketingVote
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingPage $marketingPage,
    ) {}

    public function execute(): void
    {
        $first = $this->user->marketingPages()
            ->where('marketing_page_id', $this->marketingPage->id)
            ->first();

        if ($first) {
            $wasHelpful = $first->pivot->helpful;

            $this->user->marketingPages()->detach($this->marketingPage->id);

            if ($wasHelpful) {
                $this->marketingPage->decrement('marked_helpful');
            } else {
                $this->marketingPage->decrement('marked_not_helpful');
            }
        }
    }
}
