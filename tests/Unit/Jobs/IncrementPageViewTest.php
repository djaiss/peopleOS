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

        (new IncrementPageView('https://friends.com'))->handle();

        $this->assertEquals(1, $page->fresh()->pageviews);
        $this->assertEquals(1, MarketingPage::count());
    }

    #[Test]
    public function it_should_create_page_and_increment_pageview_when_page_does_not_exist()
    {
        $this->assertEquals(0, MarketingPage::count());
        $url = 'https://friends.com';

        (new IncrementPageView($url))->handle();

        $page = MarketingPage::where('url', $url)->first();
        $this->assertNotNull($page);
        $this->assertEquals(1, $page->pageviews);
        $this->assertEquals(1, MarketingPage::count());
    }
}
