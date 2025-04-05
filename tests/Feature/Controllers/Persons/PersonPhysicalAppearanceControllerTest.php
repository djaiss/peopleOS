<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonPhysicalAppearanceControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_shows_a_blank_state_when_no_physical_appearance_data_is_present(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug);

        $response->assertOk();
        $response->assertSeeText('Record details of the physical appearance of this person.');
    }

    #[Test]
    public function it_can_visit_the_edit_physical_appearance_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/physical-appearance/edit');

        $response->assertOk();
    }

    #[Test]
    public function it_can_update_person_physical_appearance(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->json('PUT', '/persons/'.$person->slug.'/physical-appearance', [
                'height' => '5\'9"',
                'weight' => '150 lbs',
                'build' => 'Athletic',
                'skin_tone' => 'Fair',
                'face_shape' => 'Oval',
                'eye_color' => 'Blue',
                'eye_shape' => 'Almond',
                'hair_color' => 'Black',
                'hair_type' => 'Straight',
                'hair_length' => 'Medium',
                'facial_hair' => 'Clean shaven',
                'scars' => 'Small scar on left hand',
                'tatoos' => 'None',
                'piercings' => 'Ears',
                'distinctive_marks' => 'Birthmark on shoulder',
                'glasses' => 'Occasionally',
                'dress_style' => 'Casual',
                'voice' => 'Deep',
            ]);

        $response->assertRedirectToRoute('person.show', $person->slug);
        $response->assertSessionHas('status', trans('Changes saved'));

        $person->refresh();
        $this->assertEquals('5\'9"', $person->height);
        $this->assertEquals('150 lbs', $person->weight);
        $this->assertEquals('Athletic', $person->build);
        $this->assertEquals('Fair', $person->skin_tone);
        $this->assertEquals('Oval', $person->face_shape);
        $this->assertEquals('Blue', $person->eye_color);
        $this->assertEquals('Almond', $person->eye_shape);
        $this->assertEquals('Black', $person->hair_color);
        $this->assertEquals('Straight', $person->hair_type);
        $this->assertEquals('Medium', $person->hair_length);
        $this->assertEquals('Clean shaven', $person->facial_hair);
        $this->assertEquals('Small scar on left hand', $person->scars);
        $this->assertEquals('None', $person->tatoos);
        $this->assertEquals('Ears', $person->piercings);
        $this->assertEquals('Birthmark on shoulder', $person->distinctive_marks);
        $this->assertEquals('Occasionally', $person->glasses);
        $this->assertEquals('Casual', $person->dress_style);
        $this->assertEquals('Deep', $person->voice);
    }

    #[Test]
    public function it_can_update_with_partial_physical_appearance_data(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->json('PUT', '/persons/'.$person->slug.'/physical-appearance', [
                'height' => '6\'0"',
                'hair_color' => 'Brown',
                'glasses' => 'Yes',
            ]);

        $response->assertRedirectToRoute('person.show', $person->slug);

        $person->refresh();
        $this->assertEquals('6\'0"', $person->height);
        $this->assertEquals('Brown', $person->hair_color);
        $this->assertEquals('Yes', $person->glasses);
    }

    #[Test]
    public function it_validates_input_fields(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        // Test with array values which should be strings
        $response = $this->actingAs($user)
            ->json('PUT', '/persons/'.$person->slug.'/physical-appearance', [
                'height' => ['invalid', 'value'],
                'eye_color' => ['invalid'],
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['height', 'eye_color']);
    }

    #[Test]
    public function it_handles_empty_values_correctly(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'height' => '5\'8"',
            'eye_color' => 'Green',
        ]);

        $response = $this->actingAs($user)
            ->json('PUT', '/persons/'.$person->slug.'/physical-appearance', [
                'height' => null,
                'eye_color' => '',
            ]);

        $response->assertRedirectToRoute('person.show', $person->slug);

        $person->refresh();
        $this->assertNull($person->height);
        $this->assertEmpty($person->eye_color);
    }
}
