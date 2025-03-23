<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Enums\GiftStatus;
use App\Models\Gift;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonGiftControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_see_list_of_gifts(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'person_id' => $person->id,
            'status' => GiftStatus::IDEA->value,
        ]);

        $response = $this->actingAs($user)
            ->get(route('persons.gifts.index', $person->slug));

        $response->assertStatus(200);
        $response->assertViewIs('persons.gifts.index');
        $response->assertViewHas('gifts');
        $response->assertViewHas('person', $person);
        $response->assertSee($gift->name);
    }

    #[Test]
    public function user_can_see_gift_creation_form(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('persons.gifts.new', $person->slug));

        $response->assertStatus(200);
        $response->assertViewIs('persons.gifts.partials.gift-add');
        $response->assertViewHas('person', $person);
    }

    #[Test]
    public function user_can_create_a_gift(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('persons.gifts.create', $person->slug), [
                'status' => GiftStatus::IDEA->value,
                'name' => 'PlayStation 5',
                'occasion' => 'Birthday',
                'url' => 'https://example.com',
                'date' => 'known',
                'gifted_at' => '2024-03-15',
            ]);

        $response->assertRedirect(route('persons.gifts.index', $person->slug));
        $response->assertSessionHas('status', trans('The gift has been created'));

        $this->assertDatabaseHas('gifts', [
            'person_id' => $person->id,
        ]);

        $gift = $person->gifts()->first();
        $this->assertEquals('PlayStation 5', $gift->name);
        $this->assertEquals(GiftStatus::IDEA->value, $gift->status);
        $this->assertEquals('Birthday', $gift->occasion);
        $this->assertEquals('https://example.com', $gift->url);
        $this->assertEquals('2024-03-15', $gift->gifted_at->format('Y-m-d'));
    }

    #[Test]
    public function user_can_see_gift_edit_form(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'person_id' => $person->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('persons.gifts.edit', [
                'slug' => $person->slug,
                'gift' => $gift->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewIs('persons.gifts.partials.gift-edit');
        $response->assertViewHas('gift', $gift);
        $response->assertViewHas('person', $person);
    }

    #[Test]
    public function user_can_update_a_gift(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'name' => 'Original gift',
        ]);

        $response = $this->actingAs($user)
            ->put(route('persons.gifts.update', [
                'slug' => $person->slug,
                'gift' => $gift->id,
            ]), [
                'status' => GiftStatus::RECEIVED->value,
                'name' => 'Updated gift name',
                'occasion' => 'Christmas',
                'url' => 'https://example.com/updated',
                'gifted_at' => '2024-03-16',
                'date' => 'known',
            ]);

        $response->assertRedirect(route('persons.gifts.index', $person->slug));
        $response->assertSessionHas('status', trans('The gift has been updated'));

        $this->assertDatabaseHas('gifts', [
            'id' => $gift->id,
        ]);

        $gift = $person->gifts()->first();
        $this->assertEquals('Updated gift name', $gift->name);
        $this->assertEquals(GiftStatus::RECEIVED->value, $gift->status);
        $this->assertEquals('Christmas', $gift->occasion);
        $this->assertEquals('https://example.com/updated', $gift->url);
        $this->assertEquals('2024-03-16', $gift->gifted_at->format('Y-m-d'));
    }

    #[Test]
    public function user_can_delete_a_gift(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('persons.gifts.destroy', [
                'slug' => $person->slug,
                'gift' => $gift->id,
            ]));

        $response->assertRedirect(route('persons.gifts.index', $person->slug));
        $response->assertSessionHas('status', __('Gift deleted'));

        $this->assertDatabaseMissing('gifts', [
            'id' => $gift->id,
        ]);
    }
}
