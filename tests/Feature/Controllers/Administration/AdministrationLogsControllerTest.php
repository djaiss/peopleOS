<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationLogsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function administration_logs_index_can_be_rendered(): void
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
            ->get('/administration/logs');

        $response->assertStatus(200);
        $response->assertViewIs('administration.logs.index');
        $this->assertArrayHasKey('logs', $response);

        $logs = $response['logs'];
        $this->assertCount(1, $logs);
        $this->assertEquals($log->id, $logs[0]->id);
        $this->assertEquals('Ross Geller', $logs[0]->user->name);
        $this->assertEquals('profile_update', $logs[0]->action);
        $this->assertEquals('Updated their profile', $logs[0]->description);
    }

    #[Test]
    public function user_can_only_see_their_own_logs(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // Create a log for the authenticated user
        Log::factory()->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
        ]);

        // Create a log for another user
        Log::factory()->create([
            'account_id' => $otherUser->account_id,
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/logs');

        $response->assertStatus(200);
        $this->assertCount(1, $response['logs']);
    }

    #[Test]
    public function logs_are_paginated(): void
    {
        $user = User::factory()->create();

        // Create 15 logs (more than the per-page limit of 10)
        Log::factory()->count(15)->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/logs');

        $response->assertStatus(200);
        $this->assertCount(10, $response['logs']); // First page should have 10 items
        $this->assertTrue($response['logs']->hasMorePages());
    }
}
