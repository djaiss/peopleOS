<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingWhyControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_ok_response_for_why_index(): void
    {
        $response = $this->get('/why')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }
}
