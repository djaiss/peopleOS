<?php

namespace Tests\Feature\Api\Settings;

use App\Models\Gender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GenderControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_gender(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/genders', [
            'label' => 'Male',
        ]);

        $response->assertStatus(201);
        $gender = Gender::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $gender->id,
                'object' => 'gender',
                'label' => 'Male',
                'created_at' => '1514764800',
                'updated_at' => '1514764800',
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_updates_a_gender(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'label' => 'Female',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/genders/'.$gender->id, [
            'label' => 'Male',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $gender->id,
                'object' => 'gender',
                'label' => 'Male',
                'created_at' => '1514764800',
                'updated_at' => '1514764800',
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_cant_update_a_gender(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'label' => 'Female',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/genders/'.$gender->id, [
            'label' => 'Male',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_deletes_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'label' => 'Female',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/genders/'.$gender->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );
    }

    #[Test]
    public function it_cant_delete_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'label' => 'Female',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/genders/'.$gender->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_lists_all_the_genders(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        Gender::factory()->create([
            'account_id' => $user->account_id,
            'label' => 'Female',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/genders');

        $response->assertStatus(200);

        $this->assertEquals(
            1,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
