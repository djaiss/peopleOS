<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\Log;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationLogsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_get_list_of_their_logs(): void
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

        // Check that the response contains the user's logs
        $response->assertJsonCount(2, 'data');

        // Check that the response contains the expected log data
        $response->assertJsonFragment([
            'id' => $log1->id,
            'action' => 'login',
            'description' => 'User logged in',
        ]);

        $response->assertJsonFragment([
            'id' => $log2->id,
            'action' => 'update_profile',
            'description' => 'User updated their profile',
        ]);

        // Check that the response doesn't contain the other user's log
        $response->assertJsonMissing([
            'id' => $anotherLog->id,
        ]);
    }

    #[Test]
    public function logs_are_paginated(): void
    {
        $user = User::factory()->create();

        // Create 15 logs for the user (more than the default pagination of 10)
        Log::factory()->count(15)->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/logs');

        $response->assertStatus(200);

        // Check that pagination data is present
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());

        // Check that only 10 items are returned (default pagination)
        $this->assertCount(10, $response->json('data'));
    }

    #[Test]
    public function unauthenticated_user_cannot_access_logs(): void
    {
        $response = $this->json('GET', '/api/administration/logs');

        $response->assertStatus(401);
    }
}
