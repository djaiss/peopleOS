<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\MarketingPage;
use App\Models\User;
use App\Services\MarkMarketingPageAsHelpful;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarkMarketingPageAsHelpfulTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_new_helpful_relationship_when_none_exists(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create();

        $service = new MarkMarketingPageAsHelpful(
            user: $user,
            marketingPage: $marketingPage,
        );

        $service->execute();

        $this->assertDatabaseHas('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $marketingPage->id,
            'helpful' => true,
        ]);
    }

    #[Test]
    public function it_updates_existing_relationship_to_helpful(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create();

        // Create initial relationship as unhelpful
        $user->marketingPages()->attach($marketingPage->id, [
            'helpful' => false,
        ]);

        $service = new MarkMarketingPageAsHelpful(
            user: $user,
            marketingPage: $marketingPage,
        );

        $service->execute();

        $this->assertDatabaseHas('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $marketingPage->id,
            'helpful' => true,
        ]);
    }
}
