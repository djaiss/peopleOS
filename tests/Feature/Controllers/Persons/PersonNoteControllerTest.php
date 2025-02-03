<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Note;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonNoteControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_visit_the_notes_index_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);
        Note::factory()->create([
            'person_id' => $person->id,
            'content' => 'Joey does not share food!',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/notes')
            ->assertOk()
            ->assertSee('Joey does not share food!');

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('persons', $response);
        $this->assertArrayHasKey('notes', $response);
    }

    #[Test]
    public function a_user_can_create_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/notes', [
                'content' => 'Monica is a clean freak',
            ])
            ->assertRedirectToRoute('persons.notes.index', $person->slug);

        $response->assertSessionHas('status', __('Note created'));

        $note = Note::where('person_id', $person->id)->first();
        $this->assertEquals('Monica is a clean freak', $note->content);
    }

    #[Test]
    public function a_user_can_edit_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);
        $note = Note::factory()->create([
            'person_id' => $person->id,
            'content' => 'Original content',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/notes/'.$note->id.'/edit')
            ->assertOk()
            ->assertSee('Original content');

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('note', $response);
    }

    #[Test]
    public function a_user_can_update_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $note = Note::factory()->create([
            'person_id' => $person->id,
            'content' => 'Original content',
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/notes/'.$note->id, [
                'content' => 'Smelly Cat, Smelly Cat',
            ])
            ->assertRedirectToRoute('persons.notes.index', $person->slug);

        $response->assertSessionHas('status', __('Note updated'));

        $this->assertEquals(
            'Smelly Cat, Smelly Cat',
            $note->refresh()->content
        );
    }

    #[Test]
    public function a_user_can_delete_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);
        $note = Note::factory()->create([
            'person_id' => $person->id,
            'content' => 'Could I BE any more sarcastic?',
        ]);

        $response = $this->actingAs($user)
            ->delete('/persons/'.$person->slug.'/notes/'.$note->id)
            ->assertRedirectToRoute('persons.notes.index', $person->slug);

        $response->assertSessionHas('status', __('Note deleted'));
        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }

    #[Test]
    public function it_validates_required_fields_when_creating_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/notes', [
                'content' => '',
            ]);

        $response->assertInvalid(['content' => 'required']);
    }

    #[Test]
    public function it_validates_required_fields_when_updating_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $note = Note::factory()->create([
            'person_id' => $person->id,
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/notes/'.$note->id, [
                'content' => '',
            ]);

        $response->assertInvalid(['content' => 'required']);
    }
}
