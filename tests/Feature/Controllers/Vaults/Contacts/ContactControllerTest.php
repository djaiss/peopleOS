<?php

namespace Tests\Feature\Controllers\Vaults\Contacts;

use App\Models\Contact;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Masmerise\Toaster\Toaster;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_visit_the_contact_index_page(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
            'first_name' => 'Michael',
            'last_name' => 'Scott',
        ]);

        $response = $this->actingAs($user)
            ->get('/vaults/'.$vault->id.'/contacts')
            ->assertSee('Michael Scott')
            ->assertOk();

        $this->assertArrayHasKey('vault', $response);
        $this->assertArrayHasKey('contacts', $response);
        $this->assertArrayHasKey('routes', $response);

        $this->assertCount(1, $response['routes']);
        $this->assertCount(2, $response['contacts']);
        $this->assertEquals(
            [
                'id' => $contact->id,
                'name' => 'Michael Scott',
                'routes' => [
                    'show' => env('APP_URL').'/vaults/'.$vault->id.'/contacts/'.$contact->slug,
                ],
            ],
            $response['contacts']->toArray()[1]
        );
        $this->assertEquals(
            [
                'contact' => [
                    'new' => env('APP_URL').'/vaults/'.$vault->id.'/contacts/new',
                ],
            ],
            $response['routes']
        );
    }

    #[Test]
    public function a_user_can_visit_the_create_contact_page(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
            'label' => 'Asian',
        ]);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
            'label' => 'Male',
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account->id,
            'label' => 'Single',
        ]);

        $response = $this->actingAs($user)
            ->get('/vaults/'.$vault->id.'/contacts/new')
            ->assertSee('Add a contact')
            ->assertOk();

        $this->assertArrayHasKey('vault', $response);
        $this->assertArrayHasKey('routes', $response);
        $this->assertArrayHasKey('ethnicities', $response);
        $this->assertArrayHasKey('genders', $response);
        $this->assertArrayHasKey('maritalStatuses', $response);

        $this->assertCount(1, $response['routes']);
        $this->assertEquals(
            [
                'contact' => [
                    'index' => env('APP_URL').'/vaults/'.$vault->id.'/contacts',
                    'store' => env('APP_URL').'/vaults/'.$vault->id.'/contacts',
                ],
            ],
            $response['routes']
        );

        $this->assertCount(1, $response['ethnicities']);
        $this->assertCount(1, $response['genders']);
        $this->assertCount(1, $response['maritalStatuses']);
        $this->assertEquals(
            [
                'id' => $ethnicity->id,
                'name' => 'Asian',
            ],
            $response['ethnicities']->toArray()[0]
        );
        $this->assertEquals(
            [
                'id' => $gender->id,
                'name' => 'Male',
            ],
            $response['genders']->toArray()[0]
        );
        $this->assertEquals(
            [
                'id' => $maritalStatus->id,
                'name' => 'Single',
            ],
            $response['maritalStatuses']->toArray()[0]
        );
    }

    #[Test]
    public function a_user_can_create_a_contact(): void
    {
        Toaster::fake();
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account->id,
        ]);

        $this->actingAs($user)
            ->post('/vaults/'.$vault->id.'/contacts', [
                'first_name' => 'Michael',
                'last_name' => 'Scott',
                'gender_id' => $gender->id,
                'ethnicity_id' => $ethnicity->id,
                'marital_status_id' => $maritalStatus->id,
                'nickname' => '',
                'middle_name' => '',
                'maiden_name' => '',
                'patronymic_name' => '',
                'tribal_name' => '',
                'generation_name' => '',
                'romanized_name' => '',
                'nationality' => '',
                'prefix' => '',
                'suffix' => '',
            ])
            ->assertRedirectToRoute('vaults.contacts.show', [
                'vault' => $vault,
                'slug' => Contact::orderBy('id', 'desc')->first()->id.'-michael-scott',
            ]);

        Toaster::assertDispatched('The contact has been created');
    }

    #[Test]
    public function a_user_can_visit_the_contact_show_page(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
            'first_name' => 'Michael',
            'last_name' => 'Scott',
        ]);

        $response = $this->actingAs($user)
            ->get('/vaults/'.$vault->id.'/contacts/'.$contact->slug)
            ->assertSee('Michael Scott')
            ->assertOk();

        $this->assertArrayHasKey('vault', $response);
        $this->assertArrayHasKey('contact', $response);
        $this->assertArrayHasKey('contacts', $response);
        $this->assertArrayHasKey('routes', $response);
        $this->assertArrayHasKey('companies', $response);

        $this->assertCount(1, $response['routes']);
        $this->assertCount(2, $response['contacts']);
        $this->assertEquals(
            [
                'id' => $contact->id,
                'name' => 'Michael Scott',
                'routes' => [
                    'show' => env('APP_URL').'/vaults/'.$vault->id.'/contacts/'.$contact->slug,
                ],
            ],
            $response['contacts']->toArray()[1]
        );
        $this->assertEquals(
            [
                'contact' => [
                    'new' => env('APP_URL').'/vaults/'.$vault->id.'/contacts/new',
                    'edit' => env('APP_URL').'/vaults/'.$vault->id.'/contacts/'.$contact->slug.'/edit',
                ],
            ],
            $response['routes']
        );
    }

    #[Test]
    public function a_user_can_visit_the_contact_edit_page(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
            'first_name' => 'Michael',
            'last_name' => 'Scott',
        ]);

        $response = $this->actingAs($user)
            ->get('/vaults/'.$vault->id.'/contacts/'.$contact->slug.'/edit')
            ->assertSee('Michael Scott')
            ->assertOk();

        $this->assertArrayHasKey('vault', $response);
        $this->assertArrayHasKey('contact', $response);
        $this->assertArrayHasKey('ethnicities', $response);
        $this->assertArrayHasKey('genders', $response);
        $this->assertArrayHasKey('routes', $response);

        $this->assertCount(1, $response['routes']);
        $this->assertEquals(
            [
                'contact' => [
                    'index' => env('APP_URL').'/vaults/'.$vault->id.'/contacts',
                    'show' => env('APP_URL').'/vaults/'.$vault->id.'/contacts/'.$contact->slug,
                    'update' => env('APP_URL').'/vaults/'.$vault->id.'/contacts/'.$contact->slug,
                ],
            ],
            $response['routes']
        );
    }

    #[Test]
    public function a_user_can_update_a_contact(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);

        $this->actingAs($user)
            ->put('/vaults/'.$vault->id.'/contacts/'.$contact->slug, [
                'first_name' => 'Michael',
                'last_name' => 'Scott',
                'gender_id' => $gender->id,
                'ethnicity_id' => $ethnicity->id,
                'nickname' => '',
                'middle_name' => '',
                'maiden_name' => '',
                'patronymic_name' => '',
                'tribal_name' => '',
                'generation_name' => '',
                'romanized_name' => '',
                'nationality' => '',
                'prefix' => '',
                'suffix' => '',
            ])
            ->assertRedirectToRoute('vaults.contacts.show', [
                'vault' => $vault,
                'slug' => $contact->slug,
            ]);
    }

    #[Test]
    public function a_user_can_delete_a_contact(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $this->actingAs($user)
            ->delete('/vaults/'.$vault->id.'/contacts/'.$contact->slug)
            ->assertRedirectToRoute('vaults.contacts.index', [
                'vault' => $vault,
            ]);
    }
}
