<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Persons;

use App\Livewire\Persons\ManageNames;
use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageNamesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'middle_name' => 'Eustace',
            'nickname' => 'Dinosaur Guy',
            'suffix' => 'Ph.D.',
            'prefix' => 'Dr.',
            'maiden_name' => null,
        ]);
        $genders = collect();

        $component = Livewire::actingAs($user)
            ->test(ManageNames::class, [
                'genders' => $genders,
                'person' => $person,
            ]);

        $component->assertOk();

        $component->assertSet('firstName', 'Ross')
            ->assertSet('lastName', 'Geller')
            ->assertSet('middleName', 'Eustace')
            ->assertSet('nickName', 'Dinosaur Guy')
            ->assertSet('suffix', 'Ph.D.')
            ->assertSet('prefix', 'Dr.')
            ->assertSet('maidenName', null)
            ->assertSet('genderId', 1);
    }

    #[Test]
    public function it_can_update_person_names(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Female',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNames::class, [
                'genders' => collect([$gender]),
                'person' => $person,
            ])
            ->set('firstName', 'Monica')
            ->set('lastName', 'Geller')
            ->set('middleName', 'Elizabeth')
            ->set('nickName', 'Mon')
            ->set('suffix', 'Jr.')
            ->set('prefix', 'Ms.')
            ->set('maidenName', 'Green')
            ->set('genderId', $gender->id)
            ->call('store');

        $component->assertHasNoErrors();

        $person->refresh();

        $this->assertDatabaseHas('persons', [
            'id' => $person->id,
        ]);
        $this->assertEquals(
            $person->id.'-monica-geller',
            $person->slug,
        );
        $this->assertEquals(
            'Monica',
            $person->first_name,
        );
        $this->assertEquals(
            'Geller',
            $person->last_name,
        );
        $this->assertEquals(
            'Elizabeth',
            $person->middle_name,
        );
        $this->assertEquals(
            'Mon',
            $person->nickname,
        );
        $this->assertEquals(
            'Jr.',
            $person->suffix,
        );
        $this->assertEquals(
            'Ms.',
            $person->prefix,
        );
        $this->assertEquals(
            'Green',
            $person->maiden_name,
        );
        $this->assertEquals(
            $gender->id,
            $person->gender_id,
        );
    }

    #[Test]
    public function it_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNames::class, [
                'genders' => collect(),
                'person' => $person,
            ])
            ->set('firstName', '')
            ->call('store');

        $component->assertHasErrors([
            'firstName' => 'required',
        ]);
    }

    #[Test]
    public function it_validates_field_lengths(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNames::class, [
                'genders' => collect(),
                'person' => $person,
            ]);

        $component->set('firstName', 'ab')
            ->call('store')
            ->assertHasErrors(['firstName' => 'min']);

        $component->set('lastName', 'ab')
            ->call('store')
            ->assertHasErrors(['lastName' => 'min']);

        $component->set('firstName', str_repeat('a', 20001))
            ->call('store')
            ->assertHasErrors(['firstName' => 'max']);

        $component->set('lastName', str_repeat('a', 20001))
            ->call('store')
            ->assertHasErrors(['lastName' => 'max']);
    }

    #[Test]
    public function it_validates_gender_id(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageNames::class, [
                'genders' => collect(),
                'person' => $person,
            ])
            ->set('genderId', 999)
            ->call('store');

        $component->assertHasErrors([
            'genderId' => 'exists',
        ]);
    }
}
