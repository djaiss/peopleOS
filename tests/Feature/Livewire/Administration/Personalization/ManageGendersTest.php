<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Administration\Personalization;

use App\Livewire\Administration\Personalization\ManageGenders;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageGendersTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class);

        $component->assertOk();
    }

    #[Test]
    public function it_can_toggle_add_mode(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class);

        $component->assertSet('addMode', false);

        $component->call('toggleAddMode');

        $component->assertSet('addMode', true);
    }

    #[Test]
    public function it_can_create_a_gender(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class);

        $component->set('name', 'Non-binary')
            ->call('store');

        $component->assertSet('name', '');

        $this->assertEquals('Non-binary', Gender::where('account_id', $user->account_id)->first()->name);
    }

    #[Test]
    public function it_validates_name_when_creating_gender(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class);

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

        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
            'position' => 1,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class);

        $component->assertSet('editedGenderId', 0);
        $component->assertSet('name', '');

        $component->call('toggleEditMode', $gender->id);

        $component->assertSet('editedGenderId', $gender->id);
        $component->assertSet('name', 'Male');
    }

    #[Test]
    public function it_can_update_a_gender(): void
    {
        $user = User::factory()->create();

        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
            'position' => 1,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class);

        $component->call('toggleEditMode', $gender->id)
            ->set('name', 'Female')
            ->call('update');

        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
        ]);

        $this->assertEquals('Female', Gender::find($gender->id)->name);

        $component->assertSet('editedGenderId', 0)
            ->assertSet('name', '');
    }

    #[Test]
    public function it_validates_name_when_updating_gender(): void
    {
        $user = User::factory()->create();

        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class);

        $component->call('toggleEditMode', $gender->id)
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

        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class);

        $component->call('toggleEditMode', $gender->id)
            ->set('name', 'New Name')
            ->call('resetEdit');

        $component->assertSet('editedGenderId', 0)
            ->assertSet('name', '')
            ->assertHasNoErrors();
    }

    #[Test]
    public function it_can_delete_a_gender(): void
    {
        $user = User::factory()->create();

        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class);

        $component->call('delete', $gender->id);

        $this->assertDatabaseMissing('genders', [
            'id' => $gender->id,
        ]);
    }
}
