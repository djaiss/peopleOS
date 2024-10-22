<?php

namespace Tests\Feature\Api\Settings;

use App\Models\Ethnicity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EthinicityControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_an_ethnicity(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/ethnicities', [
            'label' => 'Asian',
        ]);

        $response->assertStatus(201);
        $ethnicity = Ethnicity::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $ethnicity->id,
                'object' => 'ethnicity',
                'label' => 'Asian',
                'created_at' => '1514764800',
                'updated_at' => '1514764800',
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_updates_an_ethnicity(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account_id,
            'label' => 'European',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/ethnicities/'.$ethnicity->id, [
            'label' => 'Asian',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $ethnicity->id,
                'object' => 'ethnicity',
                'label' => 'Asian',
                'created_at' => '1514764800',
                'updated_at' => '1514764800',
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_cant_update_an_ethnicity(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'label' => 'European',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/ethnicities/'.$ethnicity->id, [
            'label' => 'Asian',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_deletes_an_ethnicity(): void
    {
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account_id,
            'label' => 'European',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/ethnicities/'.$ethnicity->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );
    }

    #[Test]
    public function it_cant_delete_an_ethnicity(): void
    {
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'label' => 'European',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/ethnicities/'.$ethnicity->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_shows_an_ethnicity(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account_id,
            'label' => 'European',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/ethnicities/'.$ethnicity->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $ethnicity->id,
                'object' => 'ethnicity',
                'label' => 'European',
                'created_at' => '1514764800',
                'updated_at' => '1514764800',
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_lists_all_the_ethnicities(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        Ethnicity::factory()->create([
            'account_id' => $user->account_id,
            'label' => 'European',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/ethnicities');

        $response->assertStatus(200);

        $this->assertEquals(
            1,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
