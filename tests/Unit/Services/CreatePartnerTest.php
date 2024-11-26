<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\MaritalStatus;
use App\Models\Partner;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreatePartner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreatePartnerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_partner(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $this->executeService($user, $contact, $maritalStatus);
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
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $this->executeService($user, $contact, $maritalStatus);
    }

    #[Test]
    public function it_fails_if_marital_status_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create();
        $this->executeService($user, $contact, $maritalStatus);
    }

    private function executeService(User $user, Contact $contact, MaritalStatus $maritalStatus): void
    {
        $partner = (new CreatePartner(
            user: $user,
            contact: $contact,
            maritalStatus: $maritalStatus,
            name: 'John',
            occupation: 'Software Engineer',
        ))->execute();

        $this->assertDatabaseHas('partners', [
            'id' => $partner->id,
            'contact_id' => $contact->id,
        ]);

        $this->assertInstanceOf(
            Partner::class,
            $partner
        );

        $this->assertEquals(
            'John',
            $partner->name
        );
        $this->assertEquals(
            'Software Engineer',
            $partner->occupation
        );
        $this->assertEquals(
            $maritalStatus->id,
            $partner->marital_status_id
        );
    }
}
