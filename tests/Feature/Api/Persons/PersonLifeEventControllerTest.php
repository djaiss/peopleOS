<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Persons;

use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonLifeEventControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_a_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        Sanctum::actingAs($user);

        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $response = $this->json('POST', '/api/persons/' . $person->id . '/life-events', [
            'description' => 'Rachel got a new job at Ralph Lauren.',
            'happened_at' => '2025-03-17',
            'comment' => 'She is very excited!',
            'icon' => 'briefcase',
            'bg_color' => '#ffcc00',
            'text_color' => '#000000',
            'should_be_reminded' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('life_events', [
            'person_id' => $person->id,
        ]);

        $lifeEvent = LifeEvent::where('person_id', $person->id)->first();

        $this->assertEquals('Rachel got a new job at Ralph Lauren.', $lifeEvent->description);
        $this->assertEquals('She is very excited!', $lifeEvent->comment);
        $this->assertEquals('briefcase', $lifeEvent->icon);
        $this->assertEquals('#ffcc00', $lifeEvent->bg_color);
        $this->assertEquals('#000000', $lifeEvent->text_color);
        $this->assertEquals('2025-03-17', $lifeEvent->happened_at->format('Y-m-d'));
    }

    #[Test]
    public function user_can_update_a_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $lifeEvent = LifeEvent::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'description' => 'Rachel got a new job at Ralph Lauren.',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/' . $person->id . '/life-events/' . $lifeEvent->id, [
            'description' => 'Rachel got promoted to manager.',
            'happened_at' => '2025-03-18',
            'comment' => 'She is thrilled!',
            'icon' => 'trophy',
            'bg_color' => '#00ff00',
            'text_color' => '#ffffff',
            'should_be_reminded' => true,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('life_events', [
            'id' => $lifeEvent->id,
        ]);

        $this->assertEquals(
            'Rachel got promoted to manager.',
            $lifeEvent->refresh()->description,
        );
    }

    #[Test]
    public function user_cannot_update_life_event_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $lifeEvent = LifeEvent::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/' . $person->id . '/life-events/' . $lifeEvent->id, [
            'description' => 'Updated description',
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $lifeEvent = LifeEvent::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/' . $person->id . '/life-events/' . $lifeEvent->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('life_events', [
            'id' => $lifeEvent->id,
        ]);
    }

    #[Test]
    public function user_cannot_delete_life_event_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $lifeEvent = LifeEvent::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/' . $person->id . '/life-events/' . $lifeEvent->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_get_a_life_event(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $lifeEvent = LifeEvent::factory()->create([
            'person_id' => $person->id,
            'description' => 'Rachel got a new job at Ralph Lauren.',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/' . $person->id . '/life-events/' . $lifeEvent->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $lifeEvent->id,
            'description' => 'Rachel got a new job at Ralph Lauren.',
        ]);
    }

    #[Test]
    public function user_cannot_get_life_event_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $lifeEvent = LifeEvent::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/' . $person->id . '/life-events/' . $lifeEvent->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_get_list_of_life_events(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $lifeEvent = LifeEvent::factory()->create([
            'person_id' => $person->id,
            'description' => 'Rachel got a new job at Ralph Lauren.',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/' . $person->id . '/life-events');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $lifeEvent->id,
            'description' => 'Rachel got a new job at Ralph Lauren.',
        ]);
    }
}
