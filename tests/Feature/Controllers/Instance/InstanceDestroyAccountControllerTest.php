<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Instance;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InstanceDestroyAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function instance_administrator_can_destroy_an_account(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $account = Account::factory()->create();

        $response = $this->actingAs($user)
            ->from('/instance/accounts/'.$account->id)
            ->delete('/instance/accounts/'.$account->id);

        $response->assertRedirect('/instance');

        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id,
        ]);
    }

    #[Test]
    public function non_instance_administrator_cannot_destroy_an_account(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
        ]);
        $account = Account::factory()->create();

        $response = $this->actingAs($user)
            ->delete('/instance/accounts/'.$account->id);

        $response->assertStatus(403);

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
        ]);
    }

    #[Test]
    public function unauthenticated_user_cannot_destroy_an_account(): void
    {
        $account = Account::factory()->create();

        $response = $this->delete('/instance/accounts/'.$account->id);

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
        ]);
    }
}
