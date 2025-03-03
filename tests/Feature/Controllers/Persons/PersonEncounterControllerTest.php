<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonEncounterControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_create_an_encounter(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'slug' => 'monica-geller',
        ]);

        $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/encounters', [
                'seen_at' => '2025-01-01',
            ])
            ->assertRedirectToRoute('persons.show', $person->slug)
            ->assertSessionHas('status', 'Encounter reported');
    }
}
