<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Instance;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InstanceFreeAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function instance_administrator_can_give_free_account(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
        ]);

        $response = $this->actingAs($user)
            ->from('/instance/accounts/' . $account->id)
            ->put('/instance/accounts/' . $account->id . '/free');

        $response->assertRedirect('/instance/accounts/' . $account->id);

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'has_lifetime_access' => true,
        ]);
    }

    #[Test]
    public function non_instance_administrator_cannot_give_free_account(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
        ]);
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
        ]);

        $response = $this->actingAs($user)
            ->put('/instance/accounts/' . $account->id . '/free');

        $response->assertStatus(403);

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'has_lifetime_access' => false,
        ]);
    }

    #[Test]
    public function unauthenticated_user_cannot_give_free_account(): void
    {
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
        ]);

        $response = $this->put('/instance/accounts/' . $account->id . '/free');

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'has_lifetime_access' => false,
        ]);
    }
}
