<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonLifeEventControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_the_life_events_listing_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        LifeEvent::factory()->create([
            'person_id' => $person->id,
            'description' => 'Joey does not share food!',
            'happened_at' => '2021-01-01',
        ]);

        $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/life-events')
            ->assertOk()
            ->assertSee('Joey does not share food!');
    }

    #[Test]
    public function a_user_can_create_a_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/life-events', [
                'description' => 'Monica is a clean freak',
                'happened_at' => '2021-01-01',
            ])
            ->assertRedirectToroute('person.life-event.index', $person->slug);

        $response->assertSessionHas('status', __('The life event has been created'));

        $lifeEvent = LifeEvent::where('person_id', $person->id)->first();
        $this->assertEquals('Monica is a clean freak', $lifeEvent->description);
    }

    #[Test]
    public function a_user_can_edit_a_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);
        $lifeEvent = LifeEvent::factory()->create([
            'person_id' => $person->id,
            'description' => 'Original description',
            'happened_at' => '2021-01-01',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/life-events/'.$lifeEvent->id.'/edit')
            ->assertOk()
            ->assertSee('Original description');

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('lifeEvent', $response);
    }

    #[Test]
    public function a_user_can_update_a_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $lifeEvent = LifeEvent::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'description' => 'Original description',
            'happened_at' => '2021-01-01',
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/life-events/'.$lifeEvent->id, [
                'description' => 'Smelly Cat, Smelly Cat',
                'happened_at' => '2021-01-01',
            ])
            ->assertRedirectToroute('person.life-event.index', $person->slug);

        $response->assertSessionHas('status', __('Changes saved'));

        $this->assertEquals(
            'Smelly Cat, Smelly Cat',
            $lifeEvent->refresh()->description
        );
    }

    #[Test]
    public function a_user_can_delete_a_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);
        $lifeEvent = LifeEvent::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'description' => 'Could I BE any more sarcastic?',
        ]);

        $response = $this->actingAs($user)
            ->delete('/persons/'.$person->slug.'/life-events/'.$lifeEvent->id)
            ->assertRedirectToroute('person.life-event.index', $person->slug);

        $response->assertSessionHas('status', __('The life event has been deleted'));
        $this->assertDatabaseMissing('life_events', [
            'id' => $lifeEvent->id,
        ]);
    }

    #[Test]
    public function it_validates_required_fields_when_creating_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/life-events', [
                'description' => '',
            ]);

        $response->assertInvalid(['description' => 'required']);
    }

    #[Test]
    public function it_validates_required_fields_when_updating_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $lifeEvent = LifeEvent::factory()->create([
            'person_id' => $person->id,
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/life-events/'.$lifeEvent->id, [
                'description' => '',
            ]);

        $response->assertInvalid(['description' => 'required']);
    }
}
