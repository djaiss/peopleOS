<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Masmerise\Toaster\Toaster;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonSettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_visit_the_person_settings_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'slug' => 'monica-geller',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/settings')
            ->assertOk()
            ->assertSee('Delete person');

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('persons', $response);
    }

    #[Test]
    public function a_user_can_delete_a_person(): void
    {
        Toaster::fake();
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $this->actingAs($user)
            ->delete('/persons/'.$person->slug)
            ->assertRedirectToRoute('persons.index');

        Toaster::assertDispatched('Person deleted successfully');
    }
}
