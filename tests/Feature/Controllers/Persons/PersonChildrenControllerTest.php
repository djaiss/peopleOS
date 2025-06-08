<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Child;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonChildrenControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_displays_the_new_child_form(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/' . $person->slug . '/children/new')
            ->assertOk();

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('potentialParents', $response);
    }

    #[Test]
    public function it_shows_the_add_new_child_form(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);
        $partner = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        LoveRelationship::factory()->create([
            'person_id' => $person->id,
            'related_person_id' => $partner->id,
            'is_current' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/' . $person->slug . '/children/new')
            ->assertOk();

        $potentialParents = $response['potentialParents'];
        $this->assertCount(1, $potentialParents);
        $this->assertEquals($partner->id, $potentialParents[0]['id']);
        $this->assertEquals($partner->name, $potentialParents[0]['name']);
    }

    #[Test]
    public function it_can_create_a_child_with_first_name_only(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->json('POST', '/persons/' . $person->slug . '/children', [
                'first_name' => 'Emma',
                'last_name' => null,
            ])
            ->assertRedirectToRoute('person.family.index', $person);

        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertDatabaseHas('children', [
            'account_id' => $user->account_id,
            'parent_id' => $person->id,
            'second_parent_id' => null,
        ]);
    }

    #[Test]
    public function it_can_create_a_child_with_full_name(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->json('POST', '/persons/' . $person->slug . '/children', [
                'first_name' => 'Ben',
                'last_name' => 'Geller',
            ])
            ->assertRedirectToRoute('person.family.index', $person);

        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertDatabaseHas('children', [
            'account_id' => $user->account_id,
            'parent_id' => $person->id,
            'second_parent_id' => null,
        ]);
    }

    #[Test]
    public function it_can_create_a_child_with_second_parent(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);
        $secondParent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $response = $this->actingAs($user)
            ->json('POST', '/persons/' . $person->slug . '/children', [
                'first_name' => 'Jack',
                'last_name' => 'Bing',
                'second_parent_id' => $secondParent->id,
            ])
            ->assertRedirectToRoute('person.family.index', $person);

        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertDatabaseHas('children', [
            'account_id' => $user->account_id,
            'parent_id' => $person->id,
            'second_parent_id' => $secondParent->id,
        ]);
    }

    #[Test]
    public function it_can_destroy_a_child(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $parent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $child = Child::factory()->create([
            'account_id' => $user->account_id,
            'parent_id' => $parent->id,
            'second_parent_id' => null,
        ]);

        $response = $this->actingAs($user)
            ->delete('/persons/' . $parent->slug . '/children/' . $child->id)
            ->assertRedirectToRoute('person.family.index', $parent);

        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertDatabaseMissing('children', [
            'account_id' => $user->account_id,
            'parent_id' => $parent->id,
            'id' => $child->id,
        ]);
    }
}
