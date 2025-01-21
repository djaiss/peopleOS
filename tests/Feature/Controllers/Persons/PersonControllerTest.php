<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Masmerise\Toaster\Toaster;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_visit_the_person_index_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
            'slug' => 'monica-geller',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons')
            ->assertOk()
            ->assertSee('Monica Geller');

        $this->assertArrayHasKey('persons', $response);
        $this->assertEquals(
            [
                'id' => $person->id,
                'name' => 'Monica Geller',
                'slug' => $person->id.'-monica',
            ],
            $response['persons'][0]
        );
    }

    #[Test]
    public function a_user_can_see_a_blank_page_when_there_are_no_persons(): void
    {
        config(['app.name' => 'PeopleOS']);
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/persons')
            ->assertOk()
            ->assertSee('Welcome to PeopleOS');
    }

    #[Test]
    public function a_user_can_visit_the_create_person_page(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/new')
            ->assertSee('Add a person')
            ->assertOk();

        $this->assertArrayHasKey('genders', $response);
        $this->assertEquals(
            [
                'id' => $gender->id,
                'name' => 'Male',
            ],
            $response['genders']->toArray()[0]
        );
    }

    #[Test]
    public function a_user_can_create_a_contact(): void
    {
        Toaster::fake();
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $this->actingAs($user)
            ->post('/persons', [
                'first_name' => 'Monica',
                'last_name' => 'Geller',
                'gender_id' => $gender->id,
                'nickname' => '',
                'middle_name' => '',
                'maiden_name' => '',
                'prefix' => '',
                'suffix' => '',
            ])
            ->assertRedirectToRoute('persons.show', [
                'slug' => Person::orderBy('id', 'desc')->first()->slug,
            ]);

        Toaster::assertDispatched('The person has been created');
    }

    #[Test]
    public function a_user_can_visit_the_contact_show_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug)
            ->assertOk();

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('persons', $response);
        $this->assertEquals(
            [
                'id' => $person->id,
                'name' => 'Monica Geller',
                'slug' => $person->id.'-monica',
            ],
            $response['persons'][0]
        );
    }
}
