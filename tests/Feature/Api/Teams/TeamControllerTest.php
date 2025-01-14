<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Teams;

use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_a_team(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/teams', [
            'name' => 'Web developers',
        ]);

        $response->assertStatus(201);
        $team = Team::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $team->id,
                'object' => 'team',
                'account_id' => $user->account_id,
                'name' => 'Web developers',
                'created_at' => '1514764800',
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'account_id' => $user->account_id,
            'name' => 'Web developers',
        ]);
    }

    #[Test]
    public function it_validates_team_name_when_creating(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        // Test empty name
        $response = $this->json('POST', '/api/teams', [
            'name' => '',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);

        // Test name too long
        $response = $this->json('POST', '/api/teams', [
            'name' => str_repeat('a', 256),
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    #[Test]
    public function it_updates_a_team(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Old name',
        ]);

        $user->teams()->attach($team);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/teams/'.$team->id, [
            'name' => 'Web developers',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $team->id,
                'object' => 'team',
                'account_id' => $user->account_id,
                'name' => 'Web developers',
                'created_at' => '1514764800',
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'account_id' => $user->account_id,
            'name' => 'Web developers',
        ]);
    }

    #[Test]
    public function user_not_part_of_team_cannot_update_it(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/teams/'.$team->id, [
            'name' => 'Web developers',
        ]);

        $response->assertStatus(403);
    }

    #[Test]
    public function it_validates_team_name_when_updating(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();
        $user->teams()->attach($team);

        Sanctum::actingAs($user);

        // Test empty name
        $response = $this->json('PUT', '/api/teams/'.$team->id, [
            'name' => '',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);

        // Test name too long
        $response = $this->json('PUT', '/api/teams/'.$team->id, [
            'name' => str_repeat('a', 256),
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    #[Test]
    public function administrator_can_destroy_a_team(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $user->teams()->attach($team);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/teams/'.$team->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );

        $this->assertDatabaseMissing('teams', [
            'id' => $team->id,
        ]);
    }

    #[Test]
    public function user_not_part_of_team_cannot_destroy_it(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/teams/'.$team->id);

        $response->assertStatus(403);
    }
}
