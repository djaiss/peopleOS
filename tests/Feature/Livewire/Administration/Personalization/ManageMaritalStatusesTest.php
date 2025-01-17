<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Administration\Personalization;

use App\Livewire\Administration\Personalization\ManageMaritalStatuses;
use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageMaritalStatusesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class);

        $component->assertOk();
    }

    #[Test]
    public function it_can_toggle_add_mode(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class);

        $component->assertSet('addMode', false);

        $component->call('toggleAddMode');

        $component->assertSet('addMode', true);
    }

    #[Test]
    public function it_can_create_a_marital_status(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class);

        $component->set('name', 'Married')
            ->call('store');

        $component->assertSet('name', '');

        $this->assertEquals('Married', MaritalStatus::where('account_id', $user->account_id)->first()->name);
    }

    #[Test]
    public function it_validates_name_when_creating_marital_status(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class);

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

        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Married',
            'position' => 1,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class);

        $component->assertSet('editedMaritalStatusId', 0);
        $component->assertSet('name', '');

        $component->call('toggleEditMode', $maritalStatus->id);

        $component->assertSet('editedMaritalStatusId', $maritalStatus->id);
        $component->assertSet('name', 'Married');
    }

    #[Test]
    public function it_can_update_a_marital_status(): void
    {
        $user = User::factory()->create();

        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Married',
            'position' => 1,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class);

        $component->call('toggleEditMode', $maritalStatus->id)
            ->set('name', 'Divorced')
            ->call('update');

        $this->assertDatabaseHas('marital_statuses', [
            'id' => $maritalStatus->id,
        ]);

        $this->assertEquals('Divorced', MaritalStatus::find($maritalStatus->id)->name);

        $component->assertSet('editedMaritalStatusId', 0)
            ->assertSet('name', '');
    }

    #[Test]
    public function it_validates_name_when_updating_marital_status(): void
    {
        $user = User::factory()->create();

        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Married',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class);

        $component->call('toggleEditMode', $maritalStatus->id)
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

        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Married',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class);

        $component->call('toggleEditMode', $maritalStatus->id)
            ->set('name', 'New Name')
            ->call('resetEdit');

        $component->assertSet('editedMaritalStatusId', 0)
            ->assertSet('name', '')
            ->assertHasNoErrors();
    }

    #[Test]
    public function it_can_delete_a_marital_status(): void
    {
        $user = User::factory()->create();

        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Married',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class);

        $component->call('delete', $maritalStatus->id);

        $this->assertDatabaseMissing('marital_statuses', [
            'id' => $maritalStatus->id,
        ]);
    }
}
