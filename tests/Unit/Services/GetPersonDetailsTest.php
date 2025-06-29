<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Address;
use App\Models\Encounter;
use App\Models\Person;
use App\Models\User;
use App\Services\GetPersonDetails;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetPersonDetailsTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_data_for_the_person_details_page(): void
    {
        $user = User::factory()->create();

        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Encounter::factory()->count(2)->create([
            'person_id' => $person->id,
            'seen_at' => now(),
        ]);
        Encounter::factory()->count(2)->create([
            'person_id' => $person->id,
            'seen_at' => now()->subYear(),
        ]);

        $array = (new GetPersonDetails(
            user: $user,
            person: $person,
        ))->execute();

        $this->assertArrayHasKeys($array, [
            'person',
            'persons',
            'encounters',
            'physicalAppearance',
        ]);

        $this->assertEquals(2, $array['encounters']['currentYearCount']);
        $this->assertEquals(2, $array['encounters']['previousYearCount']);
        $this->assertCount(4, $array['encounters']['latestSeen']);
    }

    #[Test]
    public function it_returns_the_physical_appearance_details(): void
    {
        $user = User::factory()->create();

        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'height' => '6\'0"',
            'weight' => '180 lbs',
            'build' => 'Athletic',
            'skin_tone' => 'Fair',
            'face_shape' => 'Oval',
            'eye_color' => 'Blue',
        ]);

        $array = (new GetPersonDetails(
            user: $user,
            person: $person,
        ))->getPhysicalAppearanceDetails();

        $this->assertArrayHasKeys($array, [
            'height',
            'weight',
            'build',
            'skin_tone',
            'face_shape',
            'eye_color',
        ]);
    }

    #[Test]
    public function it_returns_the_addresses_details(): void
    {
        $user = User::factory()->create();

        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $address = Address::factory()->create([
            'person_id' => $person->id,
            'address_line_1' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'postal_code' => '12345',
            'country' => 'USA',
            'is_active' => true,
        ]);

        $collection = (new GetPersonDetails(
            user: $user,
            person: $person,
        ))->getAddressesDetails();

        $this->assertArrayHasKeys($collection->first(), [
            'id',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'postal_code',
            'country',
            'is_active',
        ]);

        $this->assertEquals(1, $collection->count());
        $this->assertEquals($address->id, $collection->first()['id']);
        $this->assertEquals('123 Main St', $collection->first()['address_line_1']);
        $this->assertEquals('Anytown', $collection->first()['city']);
        $this->assertEquals('CA', $collection->first()['state']);
        $this->assertEquals('12345', $collection->first()['postal_code']);
        $this->assertEquals('USA', $collection->first()['country']);
        $this->assertEquals(true, $collection->first()['is_active']);
        $this->assertEquals('Jun 29, 2025', $collection->first()['created_at']);
    }
}
