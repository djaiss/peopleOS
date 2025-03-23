<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonEncounterControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_see_a_blank_state_when_there_are_no_encounters(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug)
            ->assertOk();

        $response->assertSee('No encounters recorded yet');
    }

    #[Test]
    public function a_user_can_see_the_add_encounter_form(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/encounters/new')
            ->assertOk();

        $response->assertViewIs('persons.overview.partials.add-encounter');
        $response->assertViewHas('person', $person);
    }

    #[Test]
    public function a_user_can_create_an_encounter(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/encounters', [
                'seen_at' => '2025-01-01',
            ])
            ->assertRedirectToRoute('person.show', $person->slug);

        $response->assertSessionHas('status', 'Encounter reported');

        $this->assertDatabaseHas('encounters', [
            'person_id' => $person->id,
            'seen_at' => '2025-01-01 00:00:00',
        ]);
    }

    #[Test]
    public function it_validates_required_fields_when_creating_encounter(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/encounters', [
                'seen_at' => '',
            ]);

        $response->assertInvalid(['seen_at' => 'required']);
    }

    #[Test]
    public function it_validates_date_format_when_creating_encounter(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/encounters', [
                'seen_at' => 'invalid-date',
            ]);

        $response->assertInvalid(['seen_at' => 'date']);
    }

    #[Test]
    public function a_user_can_delete_an_encounter(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $encounter = $person->encounters()->create([
            'account_id' => $user->account_id,
            'seen_at' => '2025-01-01',
        ]);

        $response = $this->actingAs($user)
            ->delete('/persons/'.$person->slug.'/encounters/'.$encounter->id)
            ->assertRedirectToRoute('person.show', $person->slug);

        $response->assertSessionHas('status', 'Encounter deleted');

        $this->assertDatabaseMissing('encounters', [
            'id' => $encounter->id,
        ]);
    }

    #[Test]
    public function a_user_can_see_the_edit_encounter_form(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $encounter = $person->encounters()->create([
            'account_id' => $user->account_id,
            'seen_at' => '2025-01-01',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/encounters/'.$encounter->id.'/edit')
            ->assertOk();

        $response->assertViewIs('persons.overview.partials.edit-encounter');
        $response->assertViewHas('person', $person);
        $response->assertViewHas('encounter', $encounter);
    }

    #[Test]
    public function a_user_can_update_an_encounter(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $encounter = $person->encounters()->create([
            'account_id' => $user->account_id,
            'seen_at' => '2025-01-01',
            'context' => 'At Central Perk',
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/encounters/'.$encounter->id, [
                'seen_at' => '2025-02-01',
                'context' => 'At Joey\'s apartment',
            ])
            ->assertRedirectToRoute('person.show', $person->slug);

        $response->assertSessionHas('status', 'Encounter updated');

        $this->assertDatabaseHas('encounters', [
            'id' => $encounter->id,
            'seen_at' => '2025-02-01 00:00:00',
        ]);
    }

    #[Test]
    public function it_validates_required_fields_when_updating_encounter(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $encounter = $person->encounters()->create([
            'account_id' => $user->account_id,
            'seen_at' => '2025-01-01',
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/encounters/'.$encounter->id, [
                'seen_at' => '',
            ]);

        $response->assertInvalid(['seen_at' => 'required']);
    }

    #[Test]
    public function it_validates_date_format_when_updating_encounter(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $encounter = $person->encounters()->create([
            'account_id' => $user->account_id,
            'seen_at' => '2025-01-01',
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/encounters/'.$encounter->id, [
                'seen_at' => 'invalid-date',
            ]);

        $response->assertInvalid(['seen_at' => 'date']);
    }
}
