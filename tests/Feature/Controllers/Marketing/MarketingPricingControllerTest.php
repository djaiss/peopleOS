<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingPricingControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_ok_response_for_pricing_index(): void
    {
        $this->get('/pricing')
            ->assertOk();
    }
}
