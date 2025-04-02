<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\IncrementPageView;
use App\Models\MarketingPage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IncrementPageViewTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_increment_pageview_when_page_exists()
    {
        $page = MarketingPage::factory()->create([
            'url' => 'https://friends.com',
            'pageviews' => 0,
        ]);

        (new IncrementPageView($page))->handle();

        $this->assertEquals(1, $page->fresh()->pageviews);
        $this->assertEquals(1, MarketingPage::count());
    }
}
