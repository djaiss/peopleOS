<?php

namespace Tests\Feature\Livewire\Settings;

use App\Livewire\Settings\ManageGenders;
use App\Models\Contact;
use App\Models\Gender;
use App\Models\Note;
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
            ->test(ManageGenders::class, [
                'accountId' => $user->account_id,
            ]);

        $component->assertOk()->assertSee('New gender');

        $this->get('/settings/personalization')
            ->assertSeeLivewire(ManageGenders::class, [
                'accountId' => $user->account_id,
            ]);
    }

    #[Test]
    public function it_shows_an_empty_state_when_there_are_no_genders(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class, [
                'accountId' => $user->account_id,
            ]);
        $component->assertSeeHtml('id="blank-state"');
    }

    #[Test]
    public function the_empty_state_is_hidden_when_there_are_genders(): void
    {
        $user = User::factory()->create();

        Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class, [
                'accountId' => $user->account_id,
            ]);

        $component->assertDontSeeHtml('id="blank-state"');
    }

    #[Test]
    public function it_creates_a_gender(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class, [
                'accountId' => $user->account_id,
            ]);

        $component->set('name', 'This is a gender');
        $component->call('store');

        $this->assertCount(1, Gender::all());
        $this->assertEquals('This is a gender', Gender::latest()->first()->getLabel());
    }

    #[Test]
    public function it_cannot_create_a_gender_with_less_than_three_characters(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class, [
                'accountId' => $user->account_id,
            ]);

        $component->set('name', 'Ab');
        $component->call('store');

        $component->assertHasErrors('name');
        $this->assertCount(0, Gender::all());
    }

    #[Test]
    public function it_updates_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class, [
                'accountId' => $user->account_id,
            ]);

        $component->set('editedName', 'This is an updated gender');
        $component->call('update', $gender->id);

        $this->assertCount(1, Gender::all());
        $this->assertEquals('This is an updated gender', Gender::latest()->first()->getLabel());
    }

    #[Test]
    public function it_deletes_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageGenders::class, [
                'accountId' => $user->account_id,
            ]);

        $component->call('delete', $gender->id);

        $this->assertCount(0, Gender::all());
    }
}
