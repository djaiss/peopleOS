<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Enums\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_the_information_about_the_account(): void
    {
        $user = Sanctum::actingAs(
            User::factory()->create([
                'permission' => Permission::ADMINISTRATOR->value,
            ])
        );

        $user->account->update([
            'name' => 'Dunder Mifflin Paper Company',
        ]);

        $response = $this->json('GET', '/api/account');

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $user->account->id,
                'object' => 'account',
                'name' => 'Dunder Mifflin Paper Company',
            ],
            $response->json()
        );
    }

    #[Test]
    public function administrator_can_update_the_account(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $user->account->update([
            'name' => 'Dunder Mifflin Paper Company',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/account', [
            'name' => 'Sabre Corporation',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $user->id,
                'object' => 'account',
                'name' => 'Sabre Corporation',
            ],
            $response->json()
        );

        $this->assertDatabaseHas('accounts', [
            'id' => $user->account->id,
            'name' => 'Sabre Corporation',
        ]);
    }

    #[Test]
    public function non_admin_cannot_update_account(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::MEMBER->value,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/account', [
            'name' => 'Sabre Corporation',
        ]);

        $response->assertStatus(403);
    }
}
