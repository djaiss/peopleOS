<?php

namespace Tests\Feature\Api\Vaults;

use App\Models\Contact;
use App\Models\Gender;
use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_contact(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
            'label' => 'Male',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/vaults/'.$vault->id.'/contacts', [
            'gender_id' => $gender->id,
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'middle_name' => 'Gary',
            'nickname' => 'Mike',
            'maiden_name' => 'Johnson',
            'prefix' => 'Mr.',
            'suffix' => 'Jr.',
            'can_be_deleted' => true,
        ]);

        $response->assertStatus(201);
        $contact = Contact::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $contact->id,
                'object' => 'contact',
                'gender' => [
                    'id' => $gender->id,
                    'object' => 'gender',
                    'label' => 'Male',
                    'created_at' => '1514764800',
                    'updated_at' => '1514764800',
                ],
                'name' => 'Mr. Michael Scott Jr.',
                'first_name' => 'Michael',
                'last_name' => 'Scott',
                'middle_name' => 'Gary',
                'nickname' => 'Mike',
                'maiden_name' => 'Johnson',
                'prefix' => 'Mr.',
                'suffix' => 'Jr.',
                'can_be_deleted' => true,
                'created_at' => '1514764800',
                'updated_at' => '1514764800',
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_deletes_a_contact(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/'.$vault->id.'/contacts/'.$contact->slug);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );
    }

    #[Test]
    public function it_cant_delete_a_contact(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/'.$vault->id.'/contacts/'.$contact->slug);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_lists_all_the_contacts(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        Contact::factory()->create([
            'vault_id' => $vault->id,
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'middle_name' => 'Gary',
            'nickname' => 'Mike',
            'maiden_name' => 'Johnson',
            'prefix' => 'Mr.',
            'suffix' => 'Jr.',
            'can_be_deleted' => true,
        ]);
        Contact::factory()->create([
            'vault_id' => $vault->id,
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
            'middle_name' => 'Kurt',
            'nickname' => 'Dwight',
            'maiden_name' => 'Schrute',
            'prefix' => 'Mr.',
            'suffix' => 'Sr.',
            'can_be_deleted' => false,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/'.$vault->id.'/contacts');

        $response->assertStatus(200);

        $this->assertEquals(
            3,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
