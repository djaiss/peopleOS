<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Enums\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationOfficeControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function offices_can_be_listed(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/offices');

        $response->assertStatus(200);

        $this->assertArrayHasKey('user', $response);

        $this->assertEquals(
            [
                'permission' => Permission::ADMINISTRATOR->value,
            ],
            $response['user']
        );
    }

    #[Test]
    public function non_admin_cannot_access_account_page(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::MEMBER->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/account');

        $response->assertStatus(403);

        $user = User::factory()->create([
            'permission' => Permission::HR->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/offices');

        $response->assertStatus(403);
    }
}
