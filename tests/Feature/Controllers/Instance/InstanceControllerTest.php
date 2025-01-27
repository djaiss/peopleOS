<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Instance;

use App\Models\Account;
use App\Models\Log;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InstanceControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function instance_can_be_accessed_by_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/instance');

        $response->assertStatus(200);
    }

    #[Test]
    public function instance_can_not_be_accessed_by_non_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
        ]);

        $response = $this->actingAs($user)
            ->get('/instance');

        $response->assertStatus(403);
    }

    #[Test]
    public function instance_show_page_can_be_accessed_by_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $account = Account::factory()->create([
            'has_lifetime_access' => true,
        ]);
        $accountUser = User::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'email' => 'ross.geller@friends.com',
            'last_activity_at' => '2024-01-15 00:00:00',
        ]);

        Log::factory()->count(3)->create([
            'account_id' => $account->id,
            'user_id' => $accountUser->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/accounts/'.$account->id);

        $response->assertOk()
            ->assertSee('Ross Geller')
            ->assertSee('ross.geller@friends.com')
            ->assertSee('January 15, 2024')
            ->assertSee('Paid Account');
    }

    #[Test]
    public function instance_show_page_can_not_be_accessed_by_non_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
        ]);
        $account = Account::factory()->create();

        $response = $this->actingAs($user)
            ->get('/instance/accounts/'.$account->id);

        $response->assertStatus(403);
    }

    #[Test]
    public function instance_show_page_displays_trial_account_status_correctly(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->addDays(10),
        ]);
        $accountUser = User::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
            'is_instance_admin' => false,
            'last_activity_at' => '2024-01-15 00:00:00',
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/accounts/'.$account->id);

        $response->assertOk()
            ->assertSee('Trial account');
    }
}
