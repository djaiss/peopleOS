<?php

namespace Tests\Feature\Livewire\Contacts;

use App\Livewire\Contacts\ManageChildren;
use App\Models\Child;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageChildrenTest extends TestCase
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
        Child::factory()->create([
            'contact_id' => $contact->id,
            'name' => 'John Doe Child',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageChildren::class, [
                'contactId' => $contact->id,
            ]);

        $component->assertOk()->assertSee('John Doe Child');

        $this->get('/vaults/' . $vault->id . '/contacts/' . $contact->slug)
            ->assertSeeLivewire(ManageChildren::class, [
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
            ->test(ManageChildren::class, [
                'contactId' => $contact->id,
            ]);
        $component->assertOk()->assertSee('Add kids');
        $component->assertSeeHtml('id="blank-state"');
    }

    #[Test]
    public function the_empty_state_is_hidden_when_there_are_children(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        Child::factory()->create([
            'contact_id' => $contact->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageChildren::class, [
                'contactId' => $contact->id,
            ]);

        $component->assertDontSeeHtml('id="blank-state"');
    }

    #[Test]
    public function it_creates_a_child(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageChildren::class, [
                'contactId' => $contact->id,
            ]);

        $component->set('name', 'John Doe Child');
        $component->set('gender', 'boy');
        $component->call('store');

        $this->assertCount(1, Child::all());
        $this->assertEquals('John Doe Child', Child::latest()->first()->name);
    }

    #[Test]
    public function it_cannot_create_a_child_without_a_gender(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageChildren::class, [
                'contactId' => $contact->id,
            ]);

        $component->set('name', 'John Doe Child');
        $component->call('store');

        $component->assertHasErrors('gender');
        $this->assertCount(0, Child::all());
    }

    #[Test]
    public function it_updates_a_child(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageChildren::class, [
                'contactId' => $contact->id,
            ]);

        $component->call('editMode', $child->id);
        $component->set('name', 'Jane Doe Child');
        $component->set('gender', 'girl');
        $component->call('update');

        $this->assertCount(1, Child::all());
    }

    #[Test]
    public function it_deletes_a_child(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageChildren::class, [
                'contactId' => $contact->id,
            ]);

        $component->call('delete', $child->id);

        $this->assertCount(0, Child::all());
    }
}
