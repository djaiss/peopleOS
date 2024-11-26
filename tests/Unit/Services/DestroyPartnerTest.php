<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\Partner;
use App\Models\User;
use App\Models\Vault;
use App\Services\DestroyPartner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyPartnerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_partner(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $partner);
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
        $this->executeService($user, $partner);
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
        $this->executeService($user, $partner);
    }

    #[Test]
    public function it_fails_if_partner_doesnt_belong_to_contact(): void
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
        $this->executeService($user, $partner);
    }

    private function executeService(User $user, Partner $partner): void
    {
        (new DestroyPartner(
            user: $user,
            partner: $partner,
        ))->execute();

        $this->assertDatabaseMissing('partners', [
            'id' => $partner->id,
        ]);
    }
}
