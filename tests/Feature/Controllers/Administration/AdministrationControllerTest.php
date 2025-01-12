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
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
            'nickname' => 'Dwig',
            'email' => 'dwight@schrute.com',
            'last_activity_at' => now(),
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration');

        $response->assertStatus(200);

        $this->assertArrayHasKey('user', $response);

        $this->assertEquals(
            [
                'id' => $user->id,
                'first_name' => 'Dwight',
                'last_name' => 'Schrute',
                'nickname' => 'Dwig',
                'email' => 'dwight@schrute.com',
                'name' => 'Dwight Schrute',
                'permission' => Permission::ADMINISTRATOR->value,
            ],
            $response['user']
        );
    }

    #[Test]
    public function user_can_update_their_information(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->put('/administration', [
                'first_name' => 'Dwight',
                'last_name' => 'Schrute',
                'nickname' => 'Dwig',
                'email' => 'dwight@schrute.com',
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
            'nickname' => 'Dwig',
            'email' => 'dwight@schrute.com',
        ]);
    }
}
