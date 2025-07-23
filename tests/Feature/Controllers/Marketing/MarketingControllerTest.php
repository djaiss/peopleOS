<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_shows_the_homepage_of_marketing_site(): void
    {
        $mockPRs = [
            [
                'number' => 123,
                'title' => 'Test PR Title',
                'merged_at' => '2024-03-20',
                'body' => 'Test PR Description',
                'url' => 'https://github.com/test/123',
            ],
        ];

        Cache::partialMock()
            ->shouldReceive('remember')
            ->withArgs(function ($key, $ttl, $callback) {
                return $key === 'github_pull_requests';
            })
            ->once()
            ->andReturn($mockPRs);

        Cache::partialMock()
            ->shouldReceive('remember')
            ->withArgs(function ($key, $ttl, $callback) {
                return $key === 'github_stars';
            })
            ->once()
            ->andReturn(1234);

        $response = $this->get('/')
            ->assertOk();

        $response->assertViewHasAll([
            'pullRequests' => $mockPRs,
            'stars' => 1234,
            'accountNumbers',
            'marketingPage',
            'viewName' => 'marketing.index',
        ]);
    }
}
