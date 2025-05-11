<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Account;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonLoveControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_page_to_create_a_new_love_relationship(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/love/new');

        $response->assertOk();
        $this->assertArrayHasKey('person', $response);
    }

    #[Test]
    public function it_creates_a_love_relationship(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/love', [
                'first_name' => 'Rachel',
                'last_name' => 'Green',
                'nature_of_relationship' => 'Dating',
                'active' => 'active',
                'create_entry' => 'create_entry',
            ])
            ->assertRedirectToRoute('person.family.index', $person->slug);

        $response->assertSessionHas('status', __('Relationship created'));
    }

    #[Test]
    public function it_validates_required_fields_when_creating_relationship(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/love', [
                'first_name' => '',
                'nature_of_relationship' => '',
            ]);

        $response->assertInvalid([
            'first_name' => 'required',
            'nature_of_relationship' => 'required',
        ]);
    }

    #[Test]
    public function it_destroys_a_love_relationship(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);
        $partner = Person::factory()->create([
            'account_id' => $account->id,
        ]);

        $loveRelationship = LoveRelationship::factory()->create([
            'person_id' => $person->id,
            'related_person_id' => $partner->id,
            'type' => 'romantic partner',
            'is_current' => true,
        ]);

        $response = $this->actingAs($user)
            ->delete('/persons/'.$person->slug.'/love/'.$loveRelationship->id);

        $response->assertRedirect(route('person.family.index', $person->slug));
        $response->assertSessionHas('status', 'Relationship deleted');
    }
}
