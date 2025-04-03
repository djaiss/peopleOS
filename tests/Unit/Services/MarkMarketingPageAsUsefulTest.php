<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\MarketingPage;
use App\Models\User;
use App\Services\MarkMarketingPageAsUseful;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarkMarketingPageAsUsefulTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_mark_marketing_page_as_useful_for_user(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create();

        $service = new MarkMarketingPageAsUseful(
            user: $user,
            marketingPage: $marketingPage
        );

        $service->execute();

        $this->assertDatabaseHas('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $marketingPage->id,
            'helpful' => true,
        ]);
    }
}
