<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\MarketingPage;
use App\Models\User;
use App\Services\GetMarketingActivities;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetMarketingActivitiesTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_return_marketing_pages_for_user(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create();

        $user->marketingPages()->attach($marketingPage, [
            'helpful' => true,
            'comment' => 'Very useful page',
            'updated_at' => '2024-01-01 12:00:00',
        ]);

        $array = (new GetMarketingActivities($user))->execute();

        $this->assertArrayHasKey('marketingPages', $array);
        $this->assertCount(1, $array['marketingPages']);

        $this->assertEquals([
            'id' => $marketingPage->id,
            'url' => $marketingPage->url,
            'helpful' => true,
            'comment' => 'Very useful page',
            'voted_at' => '2024-01-01 12:00',
        ], $array['marketingPages'][0]);
    }

    #[Test]
    public function it_should_return_empty_array_when_user_has_no_marketing_pages(): void
    {
        $user = User::factory()->create();

        $service = new GetMarketingActivities($user);
        $result = $service->execute();

        $this->assertArrayHasKey('marketingPages', $result);
        $this->assertEmpty($result['marketingPages']);
    }
}
