<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonAllergiesFoodControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_displays_the_edit_allergies_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'food_allergies' => 'Macadamia nuts',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/' . $person->slug . '/food/allergies/edit')
            ->assertOk();

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('persons', $response);
    }

    #[Test]
    public function it_updates_food_allergies_for_a_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'food_allergies' => '',
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/' . $person->slug . '/food/allergies', [
                'person_allergies' => [
                    $person->id => 'Shellfish',
                ],
            ])
            ->assertRedirectToRoute('person.food.index', $person->slug);

        $response->assertSessionHas('status', trans('Changes saved'));
        $this->assertEquals('Shellfish', $person->fresh()->food_allergies);
    }

    #[Test]
    public function it_handles_multiple_person_allergies_updates(): void
    {
        $user = User::factory()->create();
        $person1 = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
            'food_allergies' => '',
        ]);

        $person2 = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
            'food_allergies' => '',
        ]);

        $this->actingAs($user)
            ->put('/persons/' . $person1->slug . '/food/allergies', [
                'person_allergies' => [
                    $person1->id => 'Peanuts',
                    $person2->id => 'Gluten',
                ],
            ])
            ->assertRedirectToRoute('person.food.index', $person1->slug);

        $this->assertEquals('Peanuts', $person1->fresh()->food_allergies);
        $this->assertEquals('Gluten', $person2->fresh()->food_allergies);
    }

    #[Test]
    public function it_can_clear_food_allergies(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'food_allergies' => 'Dairy',
        ]);

        $this->actingAs($user)
            ->put('/persons/' . $person->slug . '/food/allergies', [
                'person_allergies' => [
                    $person->id => '',
                ],
            ])
            ->assertRedirectToRoute('person.food.index', $person->slug);

        $this->assertEquals('', $person->fresh()->food_allergies);
    }

    #[Test]
    public function it_validates_allergies_input(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/' . $person->slug . '/food/allergies', [
                'person_allergies' => [
                    $person->id => str_repeat('a', 256),
                ],
            ]);

        $response->assertInvalid(['person_allergies.' . $person->id]);
    }
}
