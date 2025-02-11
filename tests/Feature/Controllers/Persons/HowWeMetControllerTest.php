<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HowWeMetControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_visit_the_edit_how_we_met_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug);

        $response->assertOk();
        $this->assertArrayHasKey('person', $response);
    }

    #[Test]
    public function a_user_can_toggle_how_we_met_visibility(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'how_we_met_shown' => false,
        ]);

        $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/how-we-met/toggle')
            ->assertRedirectToRoute('persons.show', $person->slug);

        $this->assertTrue($person->fresh()->how_we_met_shown);
    }

    #[Test]
    public function a_user_can_update_how_we_met_information(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->put('/persons/'.$person->slug.'/how-we-met', [
                'how_we_met' => 'Met at college',
                'how_we_met_location' => 'NYU',
                'how_we_met_first_impressions' => 'Funny guy',
                'how_we_met_year' => 2010,
                'how_we_met_month' => 1,
                'how_we_met_day' => 1,
                'add_yearly_reminder' => true,
            ])
            ->assertRedirectToRoute('persons.show', $person->slug);

        $response->assertSessionHas('status', trans('Changes saved'));

        $person->refresh();
        $this->assertEquals('Met at college', $person->how_we_met);
        $this->assertEquals('NYU', $person->how_we_met_location);
        $this->assertEquals('Funny guy', $person->how_we_met_first_impressions);
    }
}
