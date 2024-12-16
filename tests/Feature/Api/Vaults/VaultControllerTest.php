<?php

namespace Tests\Feature\Api\Vaults;

use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VaultControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_vault(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/vaults', [
            'name' => 'New vault',
            'description' => 'This is a new vault',
        ]);

        $response->assertStatus(201);

        $vault = Vault::latest()->first();

        $this->assertEquals(
            [
                'id' => $vault->id,
                'object' => 'vault',
                'name' => 'New vault',
                'description' => 'This is a new vault',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('vaults', [
            'id' => $vault->id,
        ]);
    }

    #[Test]
    public function it_updates_a_vault(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        $vault->name = 'Old vault';
        $vault->save();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/' . $vault->id, [
            'name' => 'New vault',
            'description' => 'This is a new vault',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $vault->id,
                'object' => 'vault',
                'name' => 'New vault',
                'description' => 'This is a new vault',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('vaults', [
            'id' => $vault->id,
        ]);
    }

    #[Test]
    public function it_cant_update_a_vault(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $vault = Vault::factory()->create([
            'name' => 'Old vault',
        ]);

        $response = $this->json('PUT', '/api/vaults/' . $vault->id, [
            'name' => 'New vault',
            'description' => 'This is a new vault',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_deletes_a_vault(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        $vault->name = 'Old vault';
        $vault->save();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/' . $vault->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );

        $this->assertDatabaseMissing('vaults', [
            'id' => $vault->id,
        ]);
    }

    #[Test]
    public function it_cant_delete_a_vault(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $vault = Vault::factory()->create([
            'name' => 'Old vault',
        ]);

        $response = $this->json('DELETE', '/api/vaults/' . $vault->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_shows_a_vault(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/' . $vault->id);
        $this->assertEquals(
            [
                'id' => $vault->id,
                'object' => 'vault',
                'name' => $vault->name,
                'description' => $vault->description,
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_lists_all_the_vaults(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $secondVault = $this->createVault($user);

        $vault->name = 'New vault';
        $vault->description = 'This is a new vault';
        $vault->save();
        $secondVault->name = 'Old vault';
        $secondVault->description = 'This is an old vault';
        $secondVault->save();

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults');

        $response->assertStatus(200);

        $this->assertEquals(
            $response->json()['data'],
            [
                0 => [
                    'id' => $vault->id,
                    'object' => 'vault',
                    'name' => 'New vault',
                    'description' => 'This is a new vault',
                    'created_at' => 1514764800,
                    'updated_at' => 1514764800,
                ],
                1 => [
                    'id' => $secondVault->id,
                    'object' => 'vault',
                    'name' => 'Old vault',
                    'description' => 'This is an old vault',
                    'created_at' => 1514764800,
                    'updated_at' => 1514764800,
                ],
            ]
        );
    }
}
