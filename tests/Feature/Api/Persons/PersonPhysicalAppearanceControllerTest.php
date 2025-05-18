<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Persons;

use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonPhysicalAppearanceControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_update_a_persons_physical_appearance(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-04-05 12:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);

        $this->actingAs($user);

        $payload = [
            'height' => "6'0\"",
            'weight' => '180 lbs',
            'build' => 'Athletic',
            'skin_tone' => 'Olive',
            'face_shape' => 'Square',
            'eye_color' => 'Brown',
            'eye_shape' => 'Almond',
            'hair_color' => 'Dark Brown',
            'hair_type' => 'Straight',
            'hair_length' => 'Short',
            'facial_hair' => 'Clean-shaven',
            'scars' => 'None',
            'tatoos' => 'None',
            'piercings' => 'None',
            'distinctive_marks' => 'None',
            'glasses' => 'No',
            'dress_style' => 'Casual Italian',
            'voice' => 'Deep, with "How you doin\'" catchphrase',
        ];

        $response = $this->json(
            'PATCH',
            "/api/persons/{$person->id}/physical-appearance",
            $payload,
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'object',
                'name',
                'first_name',
                'last_name',
                'middle_name',
                'nickname',
                'maiden_name',
                'prefix',
                'suffix',
                'age',
                'how_we_met',
                'can_be_deleted',
                'is_listed',
                'physical_appearance' => [
                    'height',
                    'weight',
                    'build',
                    'skin_tone',
                    'face_shape',
                    'eye_color',
                    'eye_shape',
                    'hair_color',
                    'hair_type',
                    'hair_length',
                    'facial_hair',
                    'scars',
                    'tatoos',
                    'piercings',
                    'distinctive_marks',
                    'glasses',
                    'dress_style',
                    'voice',
                ],
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertEquals(
            "6'0\"",
            $person->fresh()->height,
        );

        $this->assertEquals(
            '180 lbs',
            $person->fresh()->weight,
        );

        $this->assertEquals(
            'Athletic',
            $person->fresh()->build,
        );

        $this->assertEquals(
            'Olive',
            $person->fresh()->skin_tone,
        );

        $this->assertEquals(
            'Square',
            $person->fresh()->face_shape,
        );

        $this->assertEquals(
            'Brown',
            $person->fresh()->eye_color,
        );
    }

    #[Test]
    public function it_should_update_only_provided_attributes(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-04-05 12:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
            'height' => "5'6\"",
            'weight' => '120 lbs',
            'hair_color' => 'Blonde',
        ]);

        $this->actingAs($user);

        $payload = [
            'hair_length' => 'Medium with layers',
            'dress_style' => 'Fashion-forward',
        ];

        $response = $this->json(
            'PATCH',
            "/api/persons/{$person->id}/physical-appearance",
            $payload,
        );

        $response->assertOk();

        $updatedPerson = $person->fresh();

        $this->assertEquals(
            'Medium with layers',
            $updatedPerson->hair_length,
        );

        $this->assertEquals(
            'Fashion-forward',
            $updatedPerson->dress_style,
        );

        // Original values should be set to null
        $this->assertNull(
            $updatedPerson->height,
        );

        $this->assertNull(
            $updatedPerson->height,
        );

        $this->assertNull(
            $updatedPerson->weight,
        );

        $this->assertNull(
            $updatedPerson->hair_color,
        );
    }

    #[Test]
    public function it_should_return_404_for_nonexistent_person(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-04-05 12:00:00'));

        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->json(
            'PATCH',
            '/api/persons/999999/physical-appearance',
            ['height' => "6'2\""],
        );

        $response->assertNotFound();
    }
}
