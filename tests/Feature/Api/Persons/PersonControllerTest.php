<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Persons;

use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_get_list_of_persons(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'nickname' => 'Dr. Geller',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $person->id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'nickname' => 'Dr. Geller',
        ]);
    }

    #[Test]
    public function user_can_create_a_person(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/persons', [
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
            'nickname' => 'Chan Chan Man',
            'gender_id' => $gender->id,
            'middle_name' => 'Muriel',
            'maiden_name' => null,
            'prefix' => 'Mr',
            'suffix' => null,
            'can_be_deleted' => true,
            'is_listed' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('persons', [
            'account_id' => $user->account_id,
        ]);

        $this->assertEquals('Chandler', $response->json('data.first_name'));
        $this->assertEquals('Bing', $response->json('data.last_name'));
    }

    #[Test]
    public function user_can_update_a_person(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/'.$person->id, [
            'first_name' => 'Rachel',
            'last_name' => 'Green-Geller',
            'nickname' => 'Rach',
            'gender_id' => $gender->id,
            'middle_name' => 'Karen',
            'maiden_name' => 'Green',
            'prefix' => 'Mrs',
            'suffix' => null,
            'can_be_deleted' => true,
            'is_listed' => true,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('persons', [
            'id' => $person->id,
        ]);

        $this->assertEquals('Rachel', $response->json('data.first_name'));
        $this->assertEquals('Green-Geller', $response->json('data.last_name'));
    }

    #[Test]
    public function user_cannot_update_person_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/'.$person->id, [
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'can_be_deleted' => true,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/'.$person->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('persons', [
            'id' => $person->id,
        ]);
    }

    #[Test]
    public function user_cannot_delete_person_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/'.$person->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_cannot_delete_person_that_cant_be_deleted(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'can_be_deleted' => false,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/'.$person->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('persons', [
            'id' => $person->id,
        ]);
    }

    #[Test]
    public function user_can_get_a_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
            'nickname' => 'Pheebs',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $person->id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
            'nickname' => 'Pheebs',
        ]);
    }

    #[Test]
    public function user_cannot_get_person_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id);

        $response->assertStatus(404);
    }
}
