<?php

namespace Tests\Feature\Livewire\Settings;

use App\Livewire\Settings\ManageMaritalStatuses;
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
            ->test(ManageMaritalStatuses::class, [
                'accountId' => $user->account_id,
            ]);

        $component->assertOk()->assertSee('New marital status');

        $this->get('/settings/personalization')
            ->assertSeeLivewire(ManageMaritalStatuses::class, [
                'accountId' => $user->account_id,
            ]);
    }

    #[Test]
    public function it_shows_an_empty_state_when_there_are_no_marital_statuses(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class, [
                'accountId' => $user->account_id,
            ]);
        $component->assertSeeHtml('id="blank-state"');
    }

    #[Test]
    public function the_empty_state_is_hidden_when_there_are_marital_statuses(): void
    {
        $user = User::factory()->create();

        MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class, [
                'accountId' => $user->account_id,
            ]);

        $component->assertDontSeeHtml('id="blank-state"');
    }

    #[Test]
    public function it_creates_a_marital_status(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class, [
                'accountId' => $user->account_id,
            ]);

        $component->set('name', 'This is a marital status');
        $component->call('store');

        $this->assertCount(1, MaritalStatus::all());
        $this->assertEquals('This is a marital status', MaritalStatus::latest()->first()->getLabel());
    }

    #[Test]
    public function it_cannot_create_a_marital_status_with_less_than_three_characters(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class, [
                'accountId' => $user->account_id,
            ]);

        $component->set('name', 'Ab');
        $component->call('store');

        $component->assertHasErrors('name');
        $this->assertCount(0, MaritalStatus::all());
    }

    #[Test]
    public function it_updates_a_marital_status(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class, [
                'accountId' => $user->account_id,
            ]);

        $component->set('editedName', 'This is an updated marital status');
        $component->call('update', $maritalStatus->id);

        $this->assertCount(1, MaritalStatus::all());
        $this->assertEquals('This is an updated marital status', MaritalStatus::latest()->first()->getLabel());
    }

    #[Test]
    public function it_deletes_a_marital_status(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageMaritalStatuses::class, [
                'accountId' => $user->account_id,
            ]);

        $component->call('delete', $maritalStatus->id);

        $this->assertCount(0, MaritalStatus::all());
    }
}
