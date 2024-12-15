<?php

namespace Tests\Feature\Livewire\Contacts;

use App\Livewire\Contacts\ManagePartners;
use App\Models\Contact;
use App\Models\MaritalStatus;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManagePartnersTest extends TestCase
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
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $vault->account_id,
        ]);
        Partner::factory()->create([
            'contact_id' => $contact->id,
            'name' => 'John Doe Partner',
            'marital_status_id' => $maritalStatus->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManagePartners::class, [
                'contactId' => $contact->id,
            ]);

        $component->assertOk()->assertSee('John Doe Partner');

        $this->get('/vaults/' . $vault->id . '/contacts/' . $contact->slug)
            ->assertSeeLivewire(ManagePartners::class, [
                'contactId' => $contact->id,
            ]);
    }

    #[Test]
    public function it_shows_an_empty_state_when_there_are_no_partners(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManagePartners::class, [
                'contactId' => $contact->id,
            ]);

        $component->assertOk()->assertSee('Add partner');
        $component->assertSeeHtml('id="blank-state"');
    }

    #[Test]
    public function the_empty_state_is_hidden_when_there_are_partners(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $vault->account_id,
        ]);
        Partner::factory()->create([
            'contact_id' => $contact->id,
            'marital_status_id' => $maritalStatus->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManagePartners::class, [
                'contactId' => $contact->id,
            ]);

        $component->assertDontSeeHtml('id="blank-state"');
    }

    #[Test]
    public function it_creates_a_partner(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $vault->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManagePartners::class, [
                'contactId' => $contact->id,
            ]);

        $component->set('name', 'John Doe Partner');
        $component->set('maritalStatusId', $maritalStatus->id);
        $component->call('store');

        $this->assertCount(1, Partner::all());
        $this->assertEquals('John Doe Partner', Partner::latest()->first()->name);
    }

    #[Test]
    public function it_cannot_create_a_partner_without_a_marital_status(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManagePartners::class, [
                'contactId' => $contact->id,
            ]);

        $component->set('name', 'John Doe Partner');
        $component->call('store');

        $component->assertHasErrors('maritalStatusId');
        $this->assertCount(0, Partner::all());
    }

    #[Test]
    public function it_updates_a_partner(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $vault->account_id,
        ]);
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
            'marital_status_id' => $maritalStatus->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManagePartners::class, [
                'contactId' => $contact->id,
            ]);

        $component->call('editMode', $partner->id);
        $component->set('name', 'Jane Doe Partner');
        $component->set('maritalStatusId', $maritalStatus->id);
        $component->call('update');

        $this->assertCount(1, Partner::all());
        $this->assertEquals('Jane Doe Partner', Partner::latest()->first()->name);
    }

    #[Test]
    public function it_deletes_a_partner(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $vault->account_id,
        ]);
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
            'marital_status_id' => $maritalStatus->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManagePartners::class, [
                'contactId' => $contact->id,
            ]);

        $component->call('delete', $partner->id);

        $this->assertCount(0, Partner::all());
    }
}
