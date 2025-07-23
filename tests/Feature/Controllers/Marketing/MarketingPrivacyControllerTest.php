<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingPrivacyControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_ok_response_for_privacy_index(): void
    {
        $response = $this->get('/privacy')
            ->assertOk();

        $response->assertViewHasAll([
            'marketingPage',
            'viewName',
        ]);
    }
}
