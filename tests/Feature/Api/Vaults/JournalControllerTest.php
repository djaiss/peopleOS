<?php

namespace Tests\Feature\Api\Vaults;

use App\Models\Journal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JournalControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_journal(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/vaults/' . $vault->id . '/journals', [
            'name' => 'Daily journal',
        ]);

        $response->assertStatus(201);
        $journal = Journal::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'data' => [
                    'id' => $journal->id,
                    'object' => 'journal',
                    'vault' => [
                        'id' => $vault->id,
                        'name' => $vault->name,
                    ],
                    'name' => 'Daily journal',
                    'created_at' => 1514764800,
                    'updated_at' => 1514764800,
                ],
            ],
            $response->json()
        );

        $this->assertDatabaseHas('journals', [
            'id' => $journal->id,
            'vault_id' => $vault->id,
        ]);
    }

    #[Test]
    public function it_updates_a_journal(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $journal = Journal::factory()->create([
            'vault_id' => $vault->id,
            'name' => 'Old journal',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/' . $vault->id . '/journals/' . $journal->id, [
            'name' => 'Updated journal',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'data' => [
                    'id' => $journal->id,
                    'object' => 'journal',
                    'vault' => [
                        'id' => $vault->id,
                        'name' => $vault->name,
                    ],
                    'name' => 'Updated journal',
                    'created_at' => 1514764800,
                    'updated_at' => 1514764800,
                ],
            ],
            $response->json()
        );

        $this->assertDatabaseHas('journals', [
            'id' => $journal->id,
            'vault_id' => $vault->id,
        ]);
    }

    #[Test]
    public function it_cant_update_a_journal(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $journal = Journal::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/' . $vault->id . '/journals/' . $journal->id, [
            'name' => 'Updated journal',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_deletes_a_journal(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $journal = Journal::factory()->create([
            'vault_id' => $vault->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/' . $vault->id . '/journals/' . $journal->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );

        $this->assertDatabaseMissing('journals', [
            'id' => $journal->id,
        ]);
    }

    #[Test]
    public function it_cant_delete_a_journal(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $journal = Journal::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/' . $vault->id . '/journals/' . $journal->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_shows_a_journal(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $journal = Journal::factory()->create([
            'vault_id' => $vault->id,
            'name' => 'Daily journal',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/' . $vault->id . '/journals/' . $journal->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'data' => [
                    'id' => $journal->id,
                    'object' => 'journal',
                    'vault' => [
                        'id' => $vault->id,
                        'name' => $vault->name,
                    ],
                    'name' => 'Daily journal',
                    'created_at' => 1514764800,
                    'updated_at' => 1514764800,
                ],
            ],
            $response->json()
        );
    }

    #[Test]
    public function it_lists_all_the_journals(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        Journal::factory()->create([
            'vault_id' => $vault->id,
            'name' => 'Daily journal',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/' . $vault->id . '/journals');

        $response->assertStatus(200);

        $this->assertEquals(
            1,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
