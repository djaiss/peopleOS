<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use App\Services\FetchMergedPRs;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_the_homepage_of_marketing_site(): void
    {
        $mockPRs = [
            [
                'number' => 123,
                'title' => 'Test PR Title',
                'merged_at' => '2024-03-20',
                'body' => 'Test PR Description',
                'url' => 'https://github.com/test/123'
            ]
        ];

        Cache::partialMock()
            ->shouldReceive('remember')
            ->withArgs(function ($key, $ttl, $callback) {
                return $key === 'github_pull_requests';
            })
            ->once()
            ->andReturn($mockPRs);

        $response = $this->get('/')
            ->assertOk();

        $response->assertViewHas('pullRequests', $mockPRs);
        $response->assertViewHas('accountNumbers');
        $response->assertViewHas('marketingPage');
    }
}
