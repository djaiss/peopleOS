<?php

namespace Tests\Feature\Livewire\Settings;

use App\Livewire\Settings\ManageEthnicities;
use App\Models\Ethnicity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageEthnicitiesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageEthnicities::class, [
                'accountId' => $user->account_id,
            ]);

        $component->assertOk()->assertSee('New ethnicity');

        $this->get('/settings/personalization')
            ->assertSeeLivewire(ManageEthnicities::class, [
                'accountId' => $user->account_id,
            ]);
    }

    #[Test]
    public function it_shows_an_empty_state_when_there_are_no_ethnicities(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageEthnicities::class, [
                'accountId' => $user->account_id,
            ]);
        $component->assertSeeHtml('id="blank-state"');
    }

    #[Test]
    public function the_empty_state_is_hidden_when_there_are_ethnicities(): void
    {
        $user = User::factory()->create();

        Ethnicity::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageEthnicities::class, [
                'accountId' => $user->account_id,
            ]);

        $component->assertDontSeeHtml('id="blank-state"');
    }

    #[Test]
    public function it_creates_an_ethnicity(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageEthnicities::class, [
                'accountId' => $user->account_id,
            ]);

        $component->set('name', 'This is an ethnicity');
        $component->call('store');

        $this->assertCount(1, Ethnicity::all());
        $this->assertEquals('This is an ethnicity', Ethnicity::latest()->first()->getLabel());
    }

    #[Test]
    public function it_cannot_create_an_ethnicity_with_less_than_three_characters(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageEthnicities::class, [
                'accountId' => $user->account_id,
            ]);

        $component->set('name', 'Ab');
        $component->call('store');

        $component->assertHasErrors('name');
        $this->assertCount(0, Ethnicity::all());
    }

    #[Test]
    public function it_updates_an_ethnicity(): void
    {
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageEthnicities::class, [
                'accountId' => $user->account_id,
            ]);

        $component->set('editedName', 'This is an updated ethnicity');
        $component->call('update', $ethnicity->id);

        $this->assertCount(1, Ethnicity::all());
        $this->assertEquals('This is an updated ethnicity', Ethnicity::latest()->first()->getLabel());
    }

    #[Test]
    public function it_deletes_an_ethnicity(): void
    {
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageEthnicities::class, [
                'accountId' => $user->account_id,
            ]);

        $component->call('delete', $ethnicity->id);

        $this->assertCount(0, Ethnicity::all());
    }
}
