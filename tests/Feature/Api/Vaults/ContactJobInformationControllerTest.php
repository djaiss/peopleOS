<?php

namespace Tests\Feature\Api\Vaults;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactJobInformationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_updates_the_contact_job_information(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
            'first_name' => 'Michael',
            'last_name' => 'Scott',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/' . $vault->id . '/contacts/' . $contact->id . '/job', [
            'job_title' => 'CEO',
            'company_name' => 'Dunder Mifflin',
        ]);

        $response->assertStatus(200);

        $company = $contact->refresh()->company;

        $this->assertEquals(
            [
                'id' => $contact->id,
                'object' => 'contact',
                'name' => 'Michael Scott',
                'job_title' => 'CEO',
                'company' => [
                    'id' => $company->id,
                    'name' => 'Dunder Mifflin',
                ],
            ],
            $response->json()
        );
    }
}
