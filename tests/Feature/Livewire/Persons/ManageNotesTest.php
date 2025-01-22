<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Persons;

use App\Livewire\Persons\ManageNotes;
use App\Models\Note;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageNotesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $notes = collect();

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'notes' => $notes,
                'person' => $person,
            ]);

        $component->assertOk();
    }

    #[Test]
    public function it_can_create_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'notes' => collect(),
                'person' => $person,
            ]);

        $component->set('content', 'Makes the best Thanksgiving dinner.')
            ->call('store');

        $component->assertSet('content', '')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('notes', [
            'person_id' => $person->id,
        ]);

        $note = Note::where('person_id', $person->id)->first();
        $this->assertEquals('Makes the best Thanksgiving dinner.', $note->content);
    }

    #[Test]
    public function it_validates_content_when_creating_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'notes' => collect(),
                'person' => $person,
            ]);

        $component->set('content', '')
            ->call('store')
            ->assertHasErrors(['content' => 'required']);

        $component->set('content', 'ab')
            ->call('store')
            ->assertHasErrors(['content' => 'min']);

        $component->set('content', str_repeat('a', 25600))
            ->call('store')
            ->assertHasErrors(['content' => 'max']);
    }

    #[Test]
    public function it_prepends_new_note_to_notes_collection(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);

        $existingNote = Note::factory()->create([
            'person_id' => $person->id,
            'content' => 'Loves singing Smelly Cat',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'notes' => collect([
                    [
                        'id' => $existingNote->id,
                        'content' => $existingNote->content,
                        'created_at' => $existingNote->created_at->format('M j, Y'),
                        'is_new' => false,
                    ],
                ]),
                'person' => $person,
            ]);

        $component->set('content', 'Plays guitar at Central Perk')
            ->call('store');

        $notes = $component->get('notes');
        $this->assertCount(2, $notes);
        $this->assertTrue($notes[0]['is_new']);
        $this->assertFalse($notes[1]['is_new']);
        $this->assertEquals('Plays guitar at Central Perk', $notes[0]['content']);
    }

    #[Test]
    public function it_shows_an_empty_state_when_no_notes_exist(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'notes' => collect(),
                'person' => $person,
            ]);

        $this->assertCount(0, $component->get('notes'));

        $component->set('content', 'First note for Joey')
            ->call('store');

        $notes = $component->get('notes');
        $this->assertCount(1, $notes);
        $this->assertTrue($notes[0]['is_new']);
    }

    #[Test]
    public function it_can_delete_a_note(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $note = Note::factory()->create([
            'person_id' => $person->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'notes' => collect([
                    [
                        'id' => $note->id,
                        'content' => $note->content,
                        'created_at' => $note->created_at->format('M j, Y'),
                        'is_new' => false,
                    ],
                ]),
                'person' => $person,
            ]);

        $component->call('delete', $note->id);

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);

        $notes = $component->get('notes');
        $this->assertCount(0, $notes);
    }
}
