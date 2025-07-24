<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use Tests\TestCase;
use App\Models\MarketingPage;
use PHPUnit\Framework\Attributes\Test;

class MarketingTermsControllerTest extends TestCase
{
    #[Test]
    public function it_returns_ok_response_for_terms_index(): void
    {
        MarketingPage::factory()->create();

        $response = $this->get('/terms');

        $response->assertOk();
        $response->assertViewIs('marketing.terms');
    }
}
