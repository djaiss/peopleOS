<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\MaritalStatus;
use App\Models\Partner;
use App\Models\User;
use App\Models\Vault;
use App\Services\UpdatePartner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePartnerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_partner(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $this->executeService($user, $partner, $maritalStatus);
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
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $this->executeService($user, $partner, $maritalStatus);
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
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $this->executeService($user, $partner, $maritalStatus);
    }

    #[Test]
    public function it_fails_if_partner_doesnt_belong_to_contact(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $partner = Partner::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $this->executeService($user, $partner, $maritalStatus);
    }

    #[Test]
    public function it_fails_if_marital_status_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $partner = Partner::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create();
        $this->executeService($user, $partner, $maritalStatus);
    }

    private function executeService(User $user, Partner $partner, MaritalStatus $maritalStatus): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $partner = (new UpdatePartner(
            user: $user,
            partner: $partner,
            maritalStatus: $maritalStatus,
            name: 'John',
            occupation: 'Software Engineer',
            numberOfYearsTogether: 5,
        ))->execute();

        $this->assertDatabaseHas('partners', [
            'id' => $partner->id,
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
            5,
            $partner->number_of_years_together
        );
    }
}
