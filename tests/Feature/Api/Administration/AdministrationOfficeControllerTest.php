<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\Office;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationOfficeControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_an_office(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/offices', [
            'name' => 'Scranton Branch',
        ]);

        $response->assertStatus(201);
        $office = Office::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $office->id,
                'object' => 'office',
                'account_id' => $user->account_id,
                'name' => 'Scranton Branch',
                'created_at' => '1514764800',
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
        ]);
    }

    #[Test]
    public function user_can_update_an_office(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $office = Office::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/offices/'.$office->id, [
            'name' => 'New York Branch',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $office->id,
                'object' => 'office',
                'account_id' => $user->account_id,
                'name' => 'New York Branch',
                'created_at' => '1514764800',
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'name' => 'New York Branch',
        ]);
    }

    #[Test]
    public function user_can_delete_an_office(): void
    {
        $user = User::factory()->create();
        $office = Office::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/administration/offices/'.$office->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );

        $this->assertDatabaseMissing('offices', [
            'id' => $office->id,
        ]);
    }

    #[Test]
    public function it_lists_all_the_offices(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        Office::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'New York Branch',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/offices');

        $response->assertStatus(200);

        $this->assertEquals(
            1,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
