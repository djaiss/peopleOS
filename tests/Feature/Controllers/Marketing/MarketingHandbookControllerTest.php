<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingHandbookControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_ok_response_for_handbook_index(): void
    {
        $response = $this->get('/company/handbook')
            ->assertOk();

        $response->assertViewHasAll([
            'marketingPage',
            'viewName',
        ]);
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_project(): void
    {
        $response = $this->get('/company/handbook/project')
            ->assertOk();

        $response->assertViewHasAll([
            'marketingPage',
            'viewName',
        ]);
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_principles(): void
    {
        $response = $this->get('/company/handbook/principles')
            ->assertOk();

        $response->assertViewHasAll([
            'marketingPage',
            'viewName',
        ]);
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_shipping(): void
    {
        $response = $this->get('/company/handbook/shipping')
            ->assertOk();

        $response->assertViewHasAll([
            'marketingPage',
            'viewName',
        ]);
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_money(): void
    {
        $response = $this->get('/company/handbook/money')
            ->assertOk();

        $response->assertViewHasAll([
            'marketingPage',
            'viewName',
        ]);
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_why(): void
    {
        $response = $this->get('/company/handbook/why-open-source')
            ->assertOk();

        $response->assertViewHasAll([
            'marketingPage',
            'viewName',
        ]);
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_where(): void
    {
        $response = $this->get('/company/handbook/where-am-I-going-with-this')
            ->assertOk();

        $response->assertViewHasAll([
            'marketingPage',
            'viewName',
        ]);
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_marketing(): void
    {
        $response = $this->get('/company/handbook/marketing')
            ->assertOk();

        $response->assertViewHasAll([
            'marketingPage',
            'viewName',
        ]);
    }
}
