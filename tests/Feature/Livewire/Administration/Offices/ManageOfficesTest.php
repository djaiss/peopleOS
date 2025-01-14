<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Administration\Security;

use App\Livewire\Administration\Offices\ManageOffices;
use App\Models\Office;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageOfficesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageOffices::class);

        $component->assertOk();
    }

    #[Test]
    public function it_can_toggle_add_mode(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageOffices::class);

        $component->assertSet('addMode', false);

        $component->call('toggleAddMode');

        $component->assertSet('addMode', true);
    }

    #[Test]
    public function it_can_create_an_office(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageOffices::class);

        $component->set('name', 'Scranton Office')
            ->call('store');

        $component->assertSet('name', '');

        $this->assertDatabaseHas('offices', [
            'name' => 'Scranton Office',
            'account_id' => $user->account_id,
        ]);
    }

    #[Test]
    public function it_validates_name_when_creating_office(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageOffices::class);

        $component->set('name', '')
            ->call('store')
            ->assertHasErrors(['name' => 'required']);

        $component->set('name', 'ab')
            ->call('store')
            ->assertHasErrors(['name' => 'min']);

        $component->set('name', str_repeat('a', 256))
            ->call('store')
            ->assertHasErrors(['name' => 'max']);
    }

    #[Test]
    public function it_can_toggle_edit_mode(): void
    {
        $user = User::factory()->create();

        $office = Office::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageOffices::class);

        $component->assertSet('editedOfficeId', 0);
        $component->assertSet('name', '');

        $component->call('toggleEditMode', $office->id);

        $component->assertSet('editedOfficeId', $office->id);
        $component->assertSet('name', 'Scranton Branch');
    }

    #[Test]
    public function it_can_update_an_office(): void
    {
        $user = User::factory()->create();

        $office = Office::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageOffices::class);

        $component->call('toggleEditMode', $office->id)
            ->set('name', 'Stamford Branch')
            ->call('update');

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'name' => 'Stamford Branch',
        ]);

        $component->assertSet('editedOfficeId', 0)
            ->assertSet('name', '');
    }

    #[Test]
    public function it_validates_name_when_updating_office(): void
    {
        $user = User::factory()->create();

        $office = Office::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageOffices::class);

        $component->call('toggleEditMode', $office->id)
            ->set('name', '')
            ->call('update')
            ->assertHasErrors(['name' => 'required']);

        $component->set('name', 'ab')
            ->call('update')
            ->assertHasErrors(['name' => 'min']);

        $component->set('name', str_repeat('a', 256))
            ->call('update')
            ->assertHasErrors(['name' => 'max']);
    }

    #[Test]
    public function it_can_reset_edit_mode(): void
    {
        $user = User::factory()->create();

        $office = Office::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageOffices::class);

        $component->call('toggleEditMode', $office->id)
            ->set('name', 'New Name')
            ->call('resetEdit');

        $component->assertSet('editedOfficeId', 0)
            ->assertSet('name', '')
            ->assertHasNoErrors();
    }

    #[Test]
    public function it_can_delete_an_office(): void
    {
        $user = User::factory()->create();

        $office = Office::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageOffices::class);

        $component->call('delete', $office->id);

        $this->assertDatabaseMissing('offices', [
            'id' => $office->id,
        ]);
    }
}
