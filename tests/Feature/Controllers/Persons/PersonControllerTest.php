<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Enums\KidsStatusType;
use App\Enums\MaritalStatusType;
use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_access_the_person_index_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'slug' => 'monica-geller',
        ]);
        $user->last_person_seen_id = $person->id;
        $user->save();

        $this->actingAs($user)
            ->get('/persons')
            ->assertRedirectToRoute('person.show', $person->slug);
    }

    #[Test]
    public function it_redirects_the_user_to_the_first_person_if_no_last_person_seen_is_set(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'slug' => 'monica-geller',
        ]);

        $this->actingAs($user)
            ->get('/persons')
            ->assertRedirectToRoute('person.show', $person->slug);
    }

    #[Test]
    public function a_user_can_see_a_blank_page_when_there_are_no_persons(): void
    {
        config(['app.name' => 'PeopleOS']);
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/persons')
            ->assertOk()
            ->assertSee('Welcome to PeopleOS');
    }

    #[Test]
    public function a_user_can_visit_the_create_person_page(): void
    {
        $user = User::factory()->create();
        Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        $this->actingAs($user)
            ->get('/persons/new')
            ->assertSee('Add a person')
            ->assertOk();
    }

    #[Test]
    public function a_user_can_create_a_person(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons', [
                'first_name' => 'Monica',
                'last_name' => 'Geller',
                'gender_id' => $gender->id,
                'marital_status' => MaritalStatusType::UNKNOWN->value,
                'kids_status' => KidsStatusType::UNKNOWN->value,
                'nickname' => '',
                'middle_name' => '',
                'maiden_name' => '',
                'prefix' => '',
                'suffix' => '',
                'is_listed' => true,
                'age' => 'exact',
                'estimated_age' => null,
                'birthdate' => '1990-01-01',
            ])
            ->assertRedirectToRoute('person.show', [
                'slug' => Person::orderBy('id', 'desc')->first()->slug,
            ]);

        $response->assertSessionHas('status', 'The person has been created');
    }

    #[Test]
    public function a_user_can_visit_the_person_show_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $this->actingAs($user)
            ->get('/persons/' . $person->slug)
            ->assertOk();
    }
}
