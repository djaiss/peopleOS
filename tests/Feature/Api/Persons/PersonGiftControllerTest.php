<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Persons;

use App\Models\Gift;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonGiftControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_a_gift(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/persons/'.$person->id.'/gifts', [
            'name' => 'Ross is a good friend of mine.',
            'occasion' => 'Birthday',
            'url' => 'https://www.google.com',
            'status' => 'offered',
            'date' => '2021-01-01',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('gifts', [
            'person_id' => $person->id,
        ]);

        $gift = Gift::where('person_id', $person->id)->first();

        $this->assertEquals('Ross is a good friend of mine.', $gift->name);
        $this->assertEquals('Birthday', $gift->occasion);
        $this->assertEquals('https://www.google.com', $gift->url);
        $this->assertEquals('offered', $gift->status);
        $this->assertEquals('2021-01-01', $gift->gifted_at->format('Y-m-d'));
    }

    #[Test]
    public function user_can_update_a_gift(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'name' => 'Ross is a good friend of mine.',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/'.$person->id.'/gifts/'.$gift->id, [
            'name' => 'Monica makes the best lasagna.',
            'occasion' => 'Birthday',
            'url' => 'https://www.google.com',
            'status' => 'offered',
            'date' => '2021-01-01',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('gifts', [
            'id' => $gift->id,
        ]);

        $this->assertEquals(
            'Monica makes the best lasagna.',
            $gift->refresh()->name,
        );
    }

    #[Test]
    public function user_cannot_update_gift_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $gift = Gift::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/'.$person->id.'/gifts/'.$gift->id, [
            'name' => 'Updated name',
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_gift(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/'.$person->id.'/gifts/'.$gift->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('gifts', [
            'id' => $gift->id,
        ]);
    }

    #[Test]
    public function user_cannot_delete_gift_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $gift = Gift::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/'.$person->id.'/gifts/'.$gift->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_get_a_gift(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'person_id' => $person->id,
            'name' => 'Ross is a good friend of mine.',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/gifts/'.$gift->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $gift->id,
            'name' => 'Ross is a good friend of mine.',
        ]);
    }

    #[Test]
    public function user_cannot_get_gift_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $gift = Gift::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/gifts/'.$gift->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_cannot_get_gift_from_another_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $gift = Gift::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/gifts/'.$gift->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_get_list_of_gifts(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'person_id' => $person->id,
            'name' => 'Ross is a good friend of mine.',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/gifts');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $gift->id,
            'name' => 'Ross is a good friend of mine.',
        ]);
    }
}
