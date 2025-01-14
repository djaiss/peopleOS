<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationSecurityControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function administration_security_index_can_be_rendered(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/security');

        $response->assertStatus(200);
    }
}
