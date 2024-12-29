<?php

namespace Tests\Feature\Api\Vaults;

use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactPhoneNumberControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_contact_phone_number(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/phone-numbers', [
            'label' => 'mobile',
            'phone_number' => '+1234567890',
        ]);

        $response->assertStatus(201);
        $contactPhoneNumber = ContactPhoneNumber::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $contactPhoneNumber->id,
                'object' => 'contact_phone_number',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'label' => 'mobile',
                'phone_number' => '+1234567890',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_updates_a_contact_phone_number(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $contactPhoneNumber = ContactPhoneNumber::factory()->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/phone-numbers/'.$contactPhoneNumber->id, [
            'label' => 'mobile',
            'phone_number' => '+1234567890',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $contactPhoneNumber->id,
                'object' => 'contact_phone_number',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'label' => 'mobile',
                'phone_number' => '+1234567890',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_cant_update_a_contact_phone_number(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $contactPhoneNumber = ContactPhoneNumber::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/phone-numbers/'.$contactPhoneNumber->id, [
            'label' => 'mobile',
            'phone_number' => '+1234567890',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_deletes_a_contact_phone_number(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $contactPhoneNumber = ContactPhoneNumber::factory()->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/phone-numbers/'.$contactPhoneNumber->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );
    }

    #[Test]
    public function it_cant_delete_a_contact_phone_number(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $contactPhoneNumber = ContactPhoneNumber::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/phone-numbers/'.$contactPhoneNumber->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_lists_all_the_contact_phone_numbers(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        ContactPhoneNumber::factory()->count(2)->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/phone-numbers');

        $response->assertStatus(200);

        $this->assertEquals(
            2,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
