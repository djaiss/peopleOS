<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MaritalStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_get_list_of_marital_statuses(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Divorced',
            'position' => 1,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/administration/marital-statuses');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $maritalStatus->id,
            'name' => 'Divorced',
            'position' => 1,
        ]);
    }

    #[Test]
    public function user_can_create_a_marital_status(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/marital-statuses', [
            'name' => 'Married',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('marital_statuses', [
            'account_id' => $user->account_id,
            'position' => 1,
        ]);

        $this->assertEquals('Married', $response->json('data.name'));
    }

    #[Test]
    public function user_can_update_a_marital_status(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/marital-statuses/'.$maritalStatus->id, [
            'name' => 'Single',
            'position' => 3,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('marital_statuses', [
            'id' => $maritalStatus->id,
            'position' => 3,
        ]);

        $this->assertEquals('Single', $response->json('data.name'));
    }

    #[Test]
    public function user_cannot_update_marital_status_from_another_account(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/marital-statuses/'.$maritalStatus->id, [
            'name' => 'Single',
            'position' => 3,
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_marital_status(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/administration/marital-statuses/'.$maritalStatus->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('marital_statuses', [
            'id' => $maritalStatus->id,
        ]);
    }

    #[Test]
    public function user_cannot_delete_marital_status_from_another_account(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/administration/marital-statuses/'.$maritalStatus->id);

        $response->assertStatus(404);
    }
}
