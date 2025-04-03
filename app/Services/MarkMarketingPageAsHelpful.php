<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MarketingPage;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MarkMarketingPageAsHelpful
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingPage $marketingPage,
    ) {}

    public function execute(): void
    {
        $exists = $this->user->marketingPages()
            ->where('marketing_page_id', $this->marketingPage->id)
            ->exists();

        if ($exists) {
            DB::table('marketing_page_user')
                ->where('user_id', $this->user->id)
                ->where('marketing_page_id', $this->marketingPage->id)
                ->update([
                    'helpful' => true,
                    'updated_at' => now(),
                ]);
        } else {
            $this->user->marketingPages()->attach($this->marketingPage->id, [
                'helpful' => true,
            ]);
        }

        $this->marketingPage->increment('marked_helpful');
    }
}
