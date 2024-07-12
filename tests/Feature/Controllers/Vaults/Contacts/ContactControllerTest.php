<?php

namespace Tests\Feature\Controllers\Vaults\Contacts;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
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
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);

        $this->actingAs($user)
            ->post('/vaults/'.$vault->id.'/contacts', [
                'first_name' => 'Michael',
                'last_name' => 'Scott',
                'nickname' => '',
                'middle_name' => '',
                'maiden_name' => '',
                'prefix' => '',
                'suffix' => '',
            ])
            ->assertRedirectToRoute('vaults.contacts.show', [
                'vault' => $vault,
                'slug' => Contact::orderBy('id', 'desc')->first()->id.'-michael-scott',
            ]);
    }
}
