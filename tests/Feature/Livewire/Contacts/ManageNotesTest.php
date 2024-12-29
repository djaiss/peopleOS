<?php

namespace Tests\Feature\Livewire\Contacts;

use App\Livewire\Contacts\ManageNotes;
use App\Models\Contact;
use App\Models\Note;
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
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'contactId' => $contact->id,
            ]);

        $component->assertOk()->assertSee('Add a note');

        $this->get('/vaults/'.$vault->id.'/contacts/'.$contact->slug)
            ->assertSeeLivewire(ManageNotes::class, [
                'contactId' => $contact->id,
            ]);
    }

    #[Test]
    public function it_shows_an_empty_state_when_there_are_no_notes(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'contactId' => $contact->id,
            ]);
        $component->assertSeeHtml('id="blank-state"');
    }

    #[Test]
    public function the_empty_state_is_hidden_when_there_are_notes(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        Note::factory()->create([
            'contact_id' => $contact->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'contactId' => $contact->id,
            ]);

        $component->assertDontSeeHtml('id="blank-state"');
    }

    #[Test]
    public function it_creates_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'contactId' => $contact->id,
            ]);

        $component->set('body', 'This is a note');
        $component->call('store');

        $this->assertCount(1, Note::all());
        $this->assertEquals('This is a note', Note::latest()->first()->body);
    }

    #[Test]
    public function it_cannot_create_a_note_with_less_than_three_characters(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'contactId' => $contact->id,
            ]);

        $component->set('body', 'Ab');
        $component->call('store');

        $component->assertHasErrors('body');
        $this->assertCount(0, Note::all());
    }

    #[Test]
    public function it_updates_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'contactId' => $contact->id,
            ]);

        $component->set('editedBody', 'This is an updated note');
        $component->call('update', $note->id);

        $this->assertCount(1, Note::all());
        $this->assertEquals('This is an updated note', Note::latest()->first()->body);
    }

    #[Test]
    public function it_deletes_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNotes::class, [
                'contactId' => $contact->id,
            ]);

        $component->call('delete', $note->id);

        $this->assertCount(0, Note::all());
    }
}
