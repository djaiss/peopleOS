<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationUserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function users_can_be_listed(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/users');

        $response->assertStatus(200);
    }
}
