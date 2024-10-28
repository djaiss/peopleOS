<?php

namespace Tests\Feature\Controllers\Vaults\Contacts;

use App\Models\Contact;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_create_a_contact(): void
    {
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
