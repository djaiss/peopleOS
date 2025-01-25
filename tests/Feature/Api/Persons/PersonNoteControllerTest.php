<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Persons;

use App\Models\Note;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonNoteControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/persons/'.$person->id.'/notes', [
            'content' => 'Ross is a good friend of mine.',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('notes', [
            'person_id' => $person->id,
        ]);

        $note = Note::where('person_id', $person->id)->first();

        $this->assertEquals('Ross is a good friend of mine.', $note->content);
    }

    #[Test]
    public function user_can_update_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $note = Note::factory()->create([
            'person_id' => $person->id,
            'content' => 'Original content',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/'.$person->id.'/notes/'.$note->id, [
            'content' => 'Monica makes the best lasagna.',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
        ]);

        $this->assertEquals(
            'Monica makes the best lasagna.',
            $note->refresh()->content,
        );

        $this->assertEquals('Monica makes the best lasagna.', $response->json('data.content'));
    }

    #[Test]
    public function user_cannot_update_note_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $note = Note::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/'.$person->id.'/notes/'.$note->id, [
            'content' => 'Updated content',
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $note = Note::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/'.$person->id.'/notes/'.$note->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }

    #[Test]
    public function user_cannot_delete_note_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $note = Note::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/'.$person->id.'/notes/'.$note->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_get_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $note = Note::factory()->create([
            'person_id' => $person->id,
            'content' => 'Phoebe sang Smelly Cat again.',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/notes/'.$note->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $note->id,
            'content' => 'Phoebe sang Smelly Cat again.',
        ]);
    }

    #[Test]
    public function user_cannot_get_note_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $note = Note::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/notes/'.$note->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_cannot_get_note_from_another_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $note = Note::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/notes/'.$note->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_get_list_of_notes(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $note = Note::factory()->create([
            'person_id' => $person->id,
            'content' => 'Joey does not share food!',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/notes');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $note->id,
            'content' => 'Joey does not share food!',
        ]);
    }
}
