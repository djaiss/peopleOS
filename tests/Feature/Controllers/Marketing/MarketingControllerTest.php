<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_the_homepage_of_marketing_site(): void
    {
        $response = $this->get('/')
            ->assertOk();

        $response->assertViewHas('accountNumbers');
        $response->assertViewHas('pullRequests');
        $response->assertViewHas('marketingPage');
    }
}
