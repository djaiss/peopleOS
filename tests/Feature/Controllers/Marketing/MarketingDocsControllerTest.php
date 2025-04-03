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
        $response = $this->get('/docs')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_introduction(): void
    {
        $response = $this->get('/docs/api/introduction')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_authentication(): void
    {
        $response = $this->get('/docs/api/authentication')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_errors(): void
    {
        $response = $this->get('/docs/api/errors')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_profile(): void
    {
        $response = $this->get('/docs/api/profile')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_logs(): void
    {
        $response = $this->get('/docs/api/logs')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_api_management(): void
    {
        $response = $this->get('/docs/api/api-management')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_genders(): void
    {
        $response = $this->get('/docs/api/genders')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_task_categories(): void
    {
        $response = $this->get('/docs/api/task-categories')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_gifts(): void
    {
        $response = $this->get('/docs/api/gifts')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_tasks(): void
    {
        $response = $this->get('/docs/api/tasks')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_journals(): void
    {
        $response = $this->get('/docs/api/journals')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_entries(): void
    {
        $response = $this->get('/docs/api/entries')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }

    #[Test]
    public function it_returns_ok_response_for_api_update_age(): void
    {
        $response = $this->get('/docs/api/update-age')
            ->assertOk();

        $response->assertViewHas('marketingPage');
    }
}
