<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Enums\Permission;
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
        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/users');

        $response->assertStatus(200);

        $this->assertArrayHasKey('user', $response);

        $this->assertEquals(
            [
                'id' => $user->id,
                'permission' => 'administrator',
            ],
            $response['user']
        );
    }

    #[Test]
    public function regular_member_cannot_access_users_page(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::MEMBER->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/users');

        $response->assertStatus(403);
    }
}