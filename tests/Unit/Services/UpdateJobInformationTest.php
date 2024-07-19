<?php

namespace Tests\Unit\Services;

use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use App\Services\UpdateJobInformation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateJobInformationTest extends TestCase
{
    use DatabaseTransactions;

    public function it_updates_the_job_information_with_a_new_company(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $contact);

        $contact = $contact->fresh();

        $this->assertEquals(
            'Paper salesman',
            $contact->job_title
        );
    }

    #[Test]
    public function it_updates_the_job_information_with_an_existing_company(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $company = Company::factory()->create([
            'vault_id' => $vault->id,
            'name' => 'Dunder Mifflin',
        ]);

        $this->executeService($user, $contact);

        $contact = $contact->fresh();

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'company_id' => $company->id,
        ]);

        $this->assertEquals(
            'Paper salesman',
            $contact->job_title
        );
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $contact);
    }

    #[Test]
    public function it_fails_if_user_doesnt_have_right_permission_in_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_VIEW, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $contact);
    }

    #[Test]
    public function it_fails_if_contact_doesnt_belong_to_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $contact);
    }

    private function executeService(User $user, Contact $contact): void
    {
        (new UpdateJobInformation(
            user: $user,
            contact: $contact,
            companyName: 'Dunder Mifflin',
            jobTitle: 'Paper salesman',
        ))->execute();
    }
}
