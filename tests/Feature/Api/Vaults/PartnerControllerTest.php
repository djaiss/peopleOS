<?php

namespace Tests\Feature\Api\Vaults;

use App\Models\Contact;
use App\Models\MaritalStatus;
use App\Models\Partner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PartnerControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_partner(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $vault->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/vaults/' . $vault->id . '/contacts/' . $contact->id . '/partners', [
            'marital_status_id' => $maritalStatus->id,
            'name' => 'John Doe',
            'occupation' => 'Software Engineer',
            'number_of_years_together' => '5',
        ]);

        $response->assertStatus(201);
        $partner = Partner::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $partner->id,
                'object' => 'partner',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'marital_status' => [
                    'id' => $maritalStatus->id,
                    'label' => $maritalStatus->getLabel(),
                ],
                'name' => 'John Doe',
                'occupation' => 'Software Engineer',
                'number_of_years_together' => '5',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('partners', [
            'id' => $partner->id,
        ]);
    }

    #[Test]
    public function it_updates_a_partner(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $vault->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/' . $vault->id . '/contacts/' . $contact->id . '/partners/' . $partner->id, [
            'marital_status_id' => $maritalStatus->id,
            'name' => 'Jane Doe',
            'occupation' => 'Software Engineer',
            'number_of_years_together' => '5',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $partner->id,
                'object' => 'partner',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'marital_status' => [
                    'id' => $maritalStatus->id,
                    'label' => $maritalStatus->getLabel(),
                ],
                'name' => 'Jane Doe',
                'occupation' => 'Software Engineer',
                'number_of_years_together' => '5',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('partners', [
            'id' => $partner->id,
        ]);
    }

    #[Test]
    public function it_cant_update_a_partner(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $partner = Partner::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $vault->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/' . $vault->id . '/contacts/' . $contact->id . '/partners/' . $partner->id, [
            'marital_status_id' => $maritalStatus->id,
            'name' => 'Jane Doe',
            'occupation' => 'Software Engineer',
            'number_of_years_together' => '5',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_deletes_a_partner(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/' . $vault->id . '/contacts/' . $contact->id . '/partners/' . $partner->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );

        $this->assertDatabaseMissing('partners', [
            'id' => $partner->id,
        ]);
    }

    #[Test]
    public function it_cant_delete_a_partner(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $partner = Partner::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/' . $vault->id . '/contacts/' . $contact->id . '/partners/' . $partner->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_shows_a_partner(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
            'name' => 'John Doe',
            'occupation' => 'Software Engineer',
            'number_of_years_together' => '5',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/' . $vault->id . '/contacts/' . $contact->id . '/partners/' . $partner->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $partner->id,
                'object' => 'partner',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'marital_status' => [
                    'id' => $partner->maritalStatus->id,
                    'label' => $partner->maritalStatus->getLabel(),
                ],
                'name' => 'John Doe',
                'occupation' => 'Software Engineer',
                'number_of_years_together' => '5',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_lists_all_the_partners(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        Partner::factory()->count(2)->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/' . $vault->id . '/contacts/' . $contact->id . '/partners');

        $response->assertStatus(200);

        $this->assertEquals(
            2,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
