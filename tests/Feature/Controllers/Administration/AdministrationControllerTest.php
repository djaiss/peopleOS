<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function administration_index_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get('/administration');

        $response->assertStatus(200);

        $this->assertArrayHasKey('user', $response);
    }
}
