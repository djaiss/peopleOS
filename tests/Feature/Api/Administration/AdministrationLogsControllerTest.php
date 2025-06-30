<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationLogsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_lists_the_logs_of_the_current_user(): void
    {
        $user = User::factory()->create();

        // Create logs for the authenticated user
        $log1 = Log::factory()->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'User logged in',
        ]);

        $log2 = Log::factory()->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'action' => 'update_profile',
            'description' => 'User updated their profile',
        ]);

        // Create a log for another user
        $anotherUser = User::factory()->create();
        $anotherLog = Log::factory()->create([
            'account_id' => $anotherUser->account_id,
            'user_id' => $anotherUser->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/logs');

        $response->assertStatus(200);

        $response->assertJsonCount(2, 'data');

        $response->assertOk()
            ->assertJsonFragment([
                'name' => $user->name,
                'action' => 'login',
                'description' => 'User logged in',
                'created_at' => $log1->created_at->timestamp,
                'updated_at' => $log1->updated_at->timestamp,
            ]);

        $response->assertJsonMissing([
            'id' => $anotherLog->id,
        ]);
    }

    #[Test]
    public function it_paginates_the_logs(): void
    {
        $user = User::factory()->create();

        Log::factory()->count(15)->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/logs');

        $response->assertStatus(200);

        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());

        $this->assertCount(10, $response->json('data'));
    }

    #[Test]
    public function it_shows_a_log(): void
    {
        Carbon::setTestNow(Carbon::create(2025, 6, 30, 12, 0, 0));

        $user = User::factory()->create();
        $log = Log::factory()->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'User logged in',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/logs/' . $log->id);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'type' => 'log',
                'attributes' => [
                    'name' => $user->name,
                    'action' => 'login',
                    'description' => 'User logged in',
                    'created_at' => 1751284800,
                    'updated_at' => 1751284800,
                ],
                'links' => [
                    'self' => config('app.url') . '/api/administration/logs/' . $log->id,
                ],
            ],
        ]);
    }
}
