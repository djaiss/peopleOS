<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Address;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonAddressControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_displays_the_new_address_form(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/' . $person->slug . '/addresses/new')
            ->assertOk();

        $this->assertArrayHasKey('person', $response);
    }

    #[Test]
    public function it_creates_an_address_with_all_fields(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        $response = $this->actingAs($user)
            ->json('POST', '/persons/' . $person->slug . '/addresses', [
                'address_line_1' => '495 Grove Street',
                'address_line_2' => 'Apt 19',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10014',
                'country' => 'United States',
                'is_active' => true,
            ])
            ->assertRedirectToRoute('person.show', $person->slug);

        $response->assertSessionHas('status', __('Address created'));

        $this->assertDatabaseHas('addresses', [
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'is_active' => true,
        ]);

        $address = Address::where('person_id', $person->id)->first();
        $this->assertEquals('495 Grove Street', $address->address_line_1);
        $this->assertEquals('Apt 19', $address->address_line_2);
        $this->assertEquals('New York', $address->city);
        $this->assertEquals('NY', $address->state);
        $this->assertEquals('10014', $address->postal_code);
        $this->assertEquals('United States', $address->country);
        $this->assertTrue($address->is_active);
    }

    #[Test]
    public function it_creates_an_inactive_address(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $response = $this->actingAs($user)
            ->json('POST', '/persons/' . $person->slug . '/addresses', [
                'address_line_1' => '1290 Avenue of the Americas',
                'city' => 'New York',
                'state' => 'NY',
                'is_active' => false,
            ])
            ->assertRedirectToRoute('person.show', $person->slug);

        $response->assertSessionHas('status', __('Address created'));

        $address = Address::where('person_id', $person->id)->first();
        $this->assertFalse($address->is_active);
    }

    #[Test]
    public function it_displays_the_edit_address_form(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);
        $address = Address::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'address_line_1' => '495 Grove Street',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/' . $person->slug . '/addresses/' . $address->id)
            ->assertOk();

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('address', $response);
    }

    #[Test]
    public function it_updates_an_address_with_all_fields(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $address = Address::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'address_line_1' => '495 Grove Street',
            'address_line_2' => 'Apt 19',
            'city' => 'New York',
            'state' => 'NY',
            'postal_code' => '10014',
            'country' => 'United States',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->json('PUT', '/persons/' . $person->slug . '/addresses/' . $address->id, [
                'address_line_1' => '90 Bedford Street',
                'address_line_2' => 'Apt 20',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10014',
                'country' => 'United States',
                'is_active' => false,
            ])
            ->assertRedirectToRoute('person.show', $person->slug);

        $response->assertSessionHas('status', __('Address updated'));

        $address->refresh();
        $this->assertEquals('90 Bedford Street', $address->address_line_1);
        $this->assertEquals('Apt 20', $address->address_line_2);
        $this->assertEquals('New York', $address->city);
        $this->assertEquals('NY', $address->state);
        $this->assertEquals('10014', $address->postal_code);
        $this->assertEquals('United States', $address->country);
        $this->assertFalse($address->is_active);
    }

    #[Test]
    public function it_destroys_an_address(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $address = Address::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'address_line_1' => '495 Grove Street',
        ]);

        $response = $this->actingAs($user)
            ->delete('/persons/' . $person->slug . '/addresses/' . $address->id)
            ->assertRedirectToRoute('person.show', $person->slug);

        $response->assertSessionHas('status', __('Address deleted'));

        $this->assertDatabaseMissing('addresses', [
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'id' => $address->id,
        ]);
    }
}
