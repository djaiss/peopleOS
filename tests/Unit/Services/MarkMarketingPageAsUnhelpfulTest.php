<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\MarketingPage;
use App\Models\User;
use App\Services\MarkMarketingPageAsUnhelpful;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarkMarketingPageAsUnhelpfulTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_mark_marketing_page_as_unhelpful_for_user(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create();

        $service = new MarkMarketingPageAsUnhelpful(
            user: $user,
            marketingPage: $marketingPage,
        );

        $service->execute();

        $this->assertDatabaseHas('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $marketingPage->id,
            'helpful' => false,
        ]);
    }

    #[Test]
    public function it_creates_new_unhelpful_relationship_when_none_exists(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create();

        $service = new MarkMarketingPageAsUnhelpful(
            user: $user,
            marketingPage: $marketingPage,
        );

        $service->execute();

        $this->assertDatabaseHas('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $marketingPage->id,
            'helpful' => false,
        ]);
    }

    #[Test]
    public function it_updates_existing_relationship_to_unhelpful(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create();

        // Create initial relationship as helpful
        $user->marketingPages()->attach($marketingPage->id, [
            'helpful' => true,
        ]);

        $service = new MarkMarketingPageAsUnhelpful(
            user: $user,
            marketingPage: $marketingPage,
        );

        $service->execute();

        $this->assertDatabaseHas('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $marketingPage->id,
            'helpful' => false,
        ]);
    }
}
