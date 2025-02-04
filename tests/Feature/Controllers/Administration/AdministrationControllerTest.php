<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\Log;
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
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $log = Log::factory()->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'action' => 'profile_update',
            'description' => 'Updated their profile',
        ]);

        $response = $this->actingAs($user)
            ->get('/administration');

        $response->assertStatus(200);
        $response->assertViewIs('administration.index');

        $this->assertArrayHasKey('logs', $response);
        $this->assertArrayHasKey('has_more_logs', $response);

        $logs = $response['logs'];
        $this->assertCount(1, $logs);
        $this->assertEquals([
            'user' => [
                'name' => 'Ross Geller',
            ],
            'action' => 'profile_update',
            'description' => 'Updated their profile',
            'created_at' => '0 seconds ago',
        ], $logs[0]);
    }

    #[Test]
    public function administration_index_shows_only_five_latest_logs(): void
    {
        $user = User::factory()->create();

        // Create 7 logs (more than the limit of 5)
        Log::factory()->count(7)->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration');

        $response->assertStatus(200);
        $this->assertCount(5, $response['logs']);
        $this->assertTrue($response['has_more_logs']);
    }

    #[Test]
    public function user_can_update_their_profile(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'email' => 'ross.geller@friends.com',
        ]);

        $response = $this->actingAs($user)
            ->from('/administration')
            ->put('/administration', [
                'first_name' => 'Monica',
                'last_name' => 'Geller',
                'email' => 'monica.geller@friends.com',
                'nickname' => 'Moni',
                'born_at' => '01/01/1979',
            ]);

        $response->assertRedirect('/administration');
        $response->assertSessionHas('status', 'Changes saved');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);

        $this->assertEquals('Monica', $user->fresh()->first_name);
        $this->assertEquals('Geller', $user->fresh()->last_name);
        $this->assertEquals('monica.geller@friends.com', $user->fresh()->email);
    }
}
