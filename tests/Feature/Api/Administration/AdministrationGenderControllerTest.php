<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\Gender;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationGenderControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_get_list_of_genders(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
            'position' => 1,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/genders');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $gender->id,
            'name' => 'Male',
            'position' => 1,
        ]);
    }

    #[Test]
    public function user_can_create_a_gender(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/genders', [
            'name' => 'Female',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('genders', [
            'account_id' => $user->account_id,
            'position' => 1,
        ]);

        $this->assertEquals('Female', $response->json('data.name'));
    }

    #[Test]
    public function user_can_update_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/genders/'.$gender->id, [
            'name' => 'Non-binary',
            'position' => 3,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
            'position' => 3,
        ]);

        $this->assertEquals('Non-binary', $response->json('data.name'));
    }

    #[Test]
    public function user_cannot_update_gender_from_another_account(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/genders/'.$gender->id, [
            'name' => 'Non-binary',
            'position' => 3,
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/administration/genders/'.$gender->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('genders', [
            'id' => $gender->id,
        ]);
    }

    #[Test]
    public function user_cannot_delete_gender_from_another_account(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/administration/genders/'.$gender->id);

        $response->assertStatus(404);
    }
}
