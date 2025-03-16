<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonInformationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_visit_the_edit_information_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/information/edit');

        $response->assertOk();
    }

    #[Test]
    public function a_user_can_update_person_information(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/information', [
                'timezone' => 'America/New_York',
                'nationalities' => 'American',
                'languages' => 'English, Spanish',
            ])
            ->assertRedirectToRoute('persons.show', $person->slug);

        $response->assertSessionHas('status', trans('Changes saved'));

        $person->refresh();
        $this->assertEquals('America/New_York', $person->timezone);
        $this->assertEquals('American', $person->nationalities);
        $this->assertEquals('English, Spanish', $person->languages);
    }

    #[Test]
    public function it_validates_timezone_input(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/information', [
                'timezone' => 'Invalid/Timezone',
            ])
            ->assertSessionHasErrors(['timezone']);
    }
}
