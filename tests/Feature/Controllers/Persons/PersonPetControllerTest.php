<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Pet;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonPetControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_see_pet_creation_form(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->get(route('person.pet.new', $person->slug));

        $response->assertStatus(200);
        $response->assertViewIs('persons.family.partials.pets.new');
        $response->assertViewHas('person', $person);
    }

    #[Test]
    public function user_can_create_a_pet(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->post(route('person.pet.store', $person->slug), [
                'name' => 'Phoebe',
                'species' => 'cat',
                'breed' => 'Siamese',
                'gender' => 'female',
            ]);

        $response->assertRedirect(route('person.family.index', $person->slug));
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertDatabaseHas('pets', [
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $pet = $person->pets()->first();
        $this->assertEquals('Phoebe', $pet->name);
        $this->assertEquals('cat', $pet->species);
        $this->assertEquals('Siamese', $pet->breed);
        $this->assertEquals('female', $pet->gender);
    }

    #[Test]
    public function user_can_see_pet_edit_form(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $pet = Pet::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'name' => 'Joey',
            'species' => 'dog',
            'breed' => 'Bulldog',
            'gender' => 'male',
        ]);

        $response = $this->actingAs($user)
            ->get(route('person.pet.edit', [
                'slug' => $person->slug,
                'pet' => $pet->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewIs('persons.family.partials.pets.edit');
        $response->assertViewHas('pet', $pet);
        $response->assertViewHas('person', $person);
    }

    #[Test]
    public function user_can_update_a_pet(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);
        $pet = Pet::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'name' => 'Original Name',
            'species' => 'fish',
            'breed' => 'Goldfish',
            'gender' => 'male',
        ]);

        $response = $this->actingAs($user)
            ->put(route('person.pet.update', [
                'slug' => $person->slug,
                'pet' => $pet->id,
            ]), [
                'name' => 'Updated Name',
                'species' => 'bird',
                'breed' => 'Parakeet',
                'gender' => 'female',
            ]);

        $response->assertRedirect(route('person.family.index', $person->slug));
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertDatabaseHas('pets', [
            'id' => $pet->id,
        ]);

        $pet = $person->pets()->first();
        $this->assertEquals('Updated Name', $pet->name);
        $this->assertEquals('bird', $pet->species);
        $this->assertEquals('Parakeet', $pet->breed);
        $this->assertEquals('female', $pet->gender);
    }

    #[Test]
    public function user_can_delete_a_pet(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $pet = Pet::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('person.pet.destroy', [
                'slug' => $person->slug,
                'pet' => $pet->id,
            ]));

        $response->assertRedirect(route('person.family.index', $person->slug));
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertDatabaseMissing('pets', [
            'id' => $pet->id,
        ]);
    }

    #[Test]
    public function user_cannot_create_pet_without_species(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('person.pet.store', $person->slug), [
                'name' => 'Phoebe',
                'breed' => 'Siamese',
                'gender' => 'female',
            ]);

        $response->assertSessionHasErrors(['species']);
        $this->assertDatabaseMissing('pets', [
            'person_id' => $person->id,
        ]);
    }

    #[Test]
    public function user_cannot_access_pet_from_different_account(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $otherUser->account_id,
        ]);
        $pet = Pet::factory()->create([
            'account_id' => $otherUser->account_id,
            'person_id' => $person->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('person.pet.edit', [
                'slug' => $person->slug,
                'pet' => $pet->id,
            ]));

        $response->assertStatus(401);
    }

    #[Test]
    public function user_cannot_update_pet_from_different_account(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $otherUser->account_id,
        ]);
        $pet = Pet::factory()->create([
            'account_id' => $otherUser->account_id,
            'person_id' => $person->id,
        ]);

        $response = $this->actingAs($user)
            ->put(route('person.pet.update', [
                'slug' => $person->slug,
                'pet' => $pet->id,
            ]), [
                'name' => 'Updated Name',
                'species' => 'cat',
            ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function user_cannot_delete_pet_from_different_account(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $otherUser->account_id,
        ]);
        $pet = Pet::factory()->create([
            'account_id' => $otherUser->account_id,
            'person_id' => $person->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('person.pet.destroy', [
                'slug' => $person->slug,
                'pet' => $pet->id,
            ]));

        $response->assertStatus(401);
    }
}
