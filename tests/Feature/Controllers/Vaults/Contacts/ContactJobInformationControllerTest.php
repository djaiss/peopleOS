<?php

namespace Tests\Feature\Controllers\Vaults\Contacts;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactJobInformationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_update_its_job_information(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $this->actingAs($user)
            ->post('/vaults/'.$vault->id.'/contacts/'.$contact->slug.'/job-information', [
                'job_title' => 'software engineer',
                'company_id' => 'Dunder Mifflin',
            ])
            ->assertSee('software engineer');
    }
}
