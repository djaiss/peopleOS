<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Enums\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function administration_index_can_be_rendered(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration');

        $response->assertStatus(200);

        $this->assertArrayHasKey('user', $response);

        $this->assertEquals(
            [
                'id' => $user->id,
                'permission' => Permission::ADMINISTRATOR->value,
            ],
            $response['user']
        );
    }
}
