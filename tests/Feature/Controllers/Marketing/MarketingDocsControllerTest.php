<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingDocsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_ok_response_for_docs_index(): void
    {
        $this->get('/docs')
            ->assertOk();
    }

    #[Test]
    public function it_returns_ok_response_for_api_introduction(): void
    {
        $this->get('/docs/api/introduction')
            ->assertOk();
    }

    #[Test]
    public function it_returns_ok_response_for_api_authentication(): void
    {
        $this->get('/docs/api/authentication')
            ->assertOk();
    }

    #[Test]
    public function it_returns_ok_response_for_api_errors(): void
    {
        $this->get('/docs/api/errors')
            ->assertOk();
    }

    #[Test]
    public function it_returns_ok_response_for_api_profile(): void
    {
        $this->get('/docs/api/profile')
            ->assertOk();
    }
}
