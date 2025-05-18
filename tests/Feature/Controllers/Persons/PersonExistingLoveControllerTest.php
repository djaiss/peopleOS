<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonExistingLoveControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_love_relationship_with_an_existing_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $relatedPerson = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/' . $person->slug . '/love/existing', [
                'person_id' => $relatedPerson->id,
                'nature_of_relationship' => 'Dating',
            ])
            ->assertRedirectToRoute('person.family.index', $person->slug);

        $response->assertSessionHas('status', __('Relationship created'));
    }
}
