<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Persons;

use App\Livewire\Persons\ManageWorkHistory;
use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageWorkHistoryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageWorkHistory::class, [
                'person' => $person,
            ]);

        $component->assertOk();
    }

    #[Test]
    public function it_can_toggle_add_mode(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageWorkHistory::class, [
                'person' => $person,
            ]);

        $component->assertSet('addMode', false);

        $component->call('toggleAddMode');

        $component->assertSet('addMode', true)
            ->assertSet('title', '')
            ->assertSet('company', '')
            ->assertSet('duration', '')
            ->assertSet('salary', '')
            ->assertSet('isCurrentJob', false);
    }

    #[Test]
    public function it_can_create_a_work_history_entry(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageWorkHistory::class, [
                'person' => $person,
            ])
            ->set('title', 'Actor')
            ->set('company', 'Days of Our Lives')
            ->set('duration', '1 year')
            ->set('salary', '$50,000')
            ->set('isCurrentJob', true)
            ->call('store');

        $this->assertDatabaseHas('work_information', [
            'person_id' => $person->id,
        ]);

        $workHistory = WorkHistory::where('person_id', $person->id)->first();
        $this->assertEquals('Actor', $workHistory->job_title);
        $this->assertEquals('Days of Our Lives', $workHistory->company_name);
        $this->assertEquals('1 year', $workHistory->duration);
        $this->assertEquals('$50,000', $workHistory->estimated_salary);
        $this->assertTrue($workHistory->active);
    }

    #[Test]
    public function it_validates_required_fields_when_creating(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageWorkHistory::class, [
                'person' => $person,
            ])
            ->set('title', '')
            ->call('store');

        $component->assertHasErrors(['title' => 'required']);
    }

    #[Test]
    public function it_validates_field_lengths(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageWorkHistory::class, [
                'person' => $person,
            ]);

        $component->set('title', 'a')
            ->call('store')
            ->assertHasErrors(['title' => 'min']);

        $component->set('company', 'a')
            ->call('store')
            ->assertHasErrors(['company' => 'min']);

        $component->set('title', str_repeat('a', 256))
            ->call('store')
            ->assertHasErrors(['title' => 'max']);

        $component->set('company', str_repeat('a', 256))
            ->call('store')
            ->assertHasErrors(['company' => 'max']);
    }

    #[Test]
    public function it_can_toggle_edit_mode(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
            'job_title' => 'Chef',
            'company_name' => 'Alessandro\'s',
            'duration' => '2 years',
            'estimated_salary' => '$60,000',
            'active' => false,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageWorkHistory::class, [
                'person' => $person,
            ]);

        $component->call('toggleEditMode', $workHistory->id);

        $component->assertSet('editedWorkHistoryId', $workHistory->id)
            ->assertSet('title', 'Chef')
            ->assertSet('company', 'Alessandro\'s')
            ->assertSet('duration', '2 years')
            ->assertSet('salary', '$60,000')
            ->assertSet('isCurrentJob', false);
    }

    #[Test]
    public function it_can_update_a_work_history_entry(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
            'job_title' => 'Waiter',
            'company_name' => 'Central Perk',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageWorkHistory::class, [
                'person' => $person,
            ]);

        $component->call('toggleEditMode', $workHistory->id)
            ->set('title', 'Head Chef')
            ->set('company', 'Javu')
            ->set('duration', '3 years')
            ->set('salary', '$70,000')
            ->set('isCurrentJob', true)
            ->call('update');

        $component->assertHasNoErrors()
            ->assertSet('editedWorkHistoryId', 0);

        $this->assertDatabaseHas('work_information', [
            'id' => $workHistory->id,
            'person_id' => $person->id,
        ]);

        $updatedHistory = WorkHistory::find($workHistory->id);
        $this->assertEquals('Head Chef', $updatedHistory->job_title);
        $this->assertEquals('Javu', $updatedHistory->company_name);
        $this->assertEquals('3 years', $updatedHistory->duration);
        $this->assertEquals('$70,000', $updatedHistory->estimated_salary);
        $this->assertTrue($updatedHistory->active);
    }

    #[Test]
    public function it_can_delete_a_work_history_entry(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageWorkHistory::class, [
                'person' => $person,
            ]);

        $component->call('delete', $workHistory->id);

        $this->assertDatabaseMissing('work_information', [
            'id' => $workHistory->id,
        ]);
    }
}
