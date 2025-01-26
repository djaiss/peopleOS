<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Persons;

use App\Livewire\Persons\ShowPersonList;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowPersonListTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ShowPersonList::class, [
                'persons' => collect([[
                    'id' => $person->id,
                    'name' => $person->name,
                    'maiden_name' => $person->maiden_name,
                    'nickname' => $person->nickname,
                    'slug' => $person->slug,
                ]]),
                'person' => $person,
            ]);

        $component->assertOk();
    }

    #[Test]
    public function it_filters_persons_by_search_term(): void
    {
        $user = User::factory()->create();

        $rachel = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
            'nickname' => null,
            'maiden_name' => null,
        ]);

        $phoebe = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
            'nickname' => 'Pheebs',
            'maiden_name' => null,
        ]);

        $persons = collect([
            [
                'id' => $rachel->id,
                'name' => $rachel->name,
                'maiden_name' => $rachel->maiden_name,
                'nickname' => $rachel->nickname,
                'slug' => $rachel->slug,
            ],
            [
                'id' => $phoebe->id,
                'name' => $phoebe->name,
                'maiden_name' => $phoebe->maiden_name,
                'nickname' => $phoebe->nickname,
                'slug' => $phoebe->slug,
            ],
        ]);

        $component = Livewire::actingAs($user)
            ->test(ShowPersonList::class, [
                'persons' => $persons,
                'person' => $rachel,
            ]);

        // Search by name
        $component->set('search', 'rachel')
            ->assertSee('Rachel Green')
            ->assertDontSee('Phoebe Buffay');

        // Search by nickname
        $component->set('search', 'pheebs')
            ->assertSee('Phoebe Buffay')
            ->assertDontSee('Rachel Green');
    }

    #[Test]
    public function it_shows_all_persons_when_search_is_empty(): void
    {
        $user = User::factory()->create();

        $rachel = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $joe = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);

        $persons = collect([
            [
                'id' => $rachel->id,
                'name' => $rachel->name,
                'maiden_name' => $rachel->maiden_name,
                'nickname' => $rachel->nickname,
                'slug' => $rachel->slug,
            ],
            [
                'id' => $joe->id,
                'name' => $joe->name,
                'maiden_name' => $joe->maiden_name,
                'nickname' => $joe->nickname,
                'slug' => $joe->slug,
            ],
        ]);

        $component = Livewire::actingAs($user)
            ->test(ShowPersonList::class, [
                'persons' => $persons,
                'person' => $rachel,
            ]);

        $component->set('search', '')
            ->assertSee('Monica Geller')
            ->assertSee('Joey Tribbiani');
    }

    #[Test]
    public function it_can_search_by_maiden_name(): void
    {
        $user = User::factory()->create();

        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Bing',
            'maiden_name' => 'Geller',
        ]);

        $persons = collect([
            [
                'id' => $person->id,
                'name' => $person->name,
                'maiden_name' => $person->maiden_name,
                'nickname' => $person->nickname,
                'slug' => $person->slug,
            ],
        ]);

        $component = Livewire::actingAs($user)
            ->test(ShowPersonList::class, [
                'persons' => $persons,
                'person' => $person,
            ]);

        $component->set('search', 'geller')
            ->assertSee('Monica Bing');
    }
}
