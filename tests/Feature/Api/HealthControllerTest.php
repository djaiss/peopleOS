<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HealthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_checks_the_health_of_the_application(): void
    {
        $response = $this->json('GET', '/api/health');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'ok',
            'status' => 200,
        ]);
    }
}
