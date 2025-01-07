<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Enums\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function administration_account_index_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $user->account->update([
            'name' => 'Dunder Mifflin Paper Company',
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/account');

        $response->assertStatus(200);

        $this->assertArrayHasKey('account', $response);
        $this->assertArrayHasKey('user', $response);

        $this->assertEquals(
            [
                'id' => $user->account->id,
                'name' => 'Dunder Mifflin Paper Company',
                'avatar' => $user->account->avatar,
            ],
            $response['account']
        );

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
    }

    #[Test]
    public function it_can_update_account_information(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $response = $this->actingAs($user)
            ->put('/administration/account', [
                'name' => 'Sabre Corporation',
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('administration.account.index'));

        $this->assertDatabaseHas('accounts', [
            'id' => $user->account->id,
            'name' => 'Sabre Corporation',
        ]);
    }

    #[Test]
    public function it_validates_account_name_when_updating(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $response = $this->actingAs($user)
            ->put('/administration/account', [
                'name' => '',
            ]);

        $response->assertSessionHasErrors(['name']);

        $response = $this->actingAs($user)
            ->put('/administration/account', [
                'name' => str_repeat('a', 256),
            ]);

        $response->assertSessionHasErrors(['name']);
    }

    #[Test]
    public function non_admin_cannot_update_account_information(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::MEMBER->value,
        ]);

        $response = $this->actingAs($user)
            ->put('/administration/account', [
                'name' => 'Sabre Corporation',
            ]);

        $response->assertStatus(403);
    }
}
