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
        $this->get('/company/handbook')
            ->assertOk();
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_project(): void
    {
        $this->get('/company/handbook/project')
            ->assertOk();
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_principles(): void
    {
        $this->get('/company/handbook/principles')
            ->assertOk();
    }

    #[Test]
    public function it_returns_ok_response_for_handbook_shipping(): void
    {
        $this->get('/company/handbook/shipping')
            ->assertOk();
    }
}
