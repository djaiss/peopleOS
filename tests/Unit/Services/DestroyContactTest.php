<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use App\Services\DestroyContact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyContactTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_contact(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $this->executeService($user, $vault, $contact);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $this->expectException(ModelNotFoundException::class);
        $this->executeService($user, $vault, $contact);
    }

    #[Test]
    public function it_fails_if_contact_doesnt_belong_to_vault(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->executeService($user, $vault, $contact);
    }

    private function executeService(User $user, Vault $vault, Contact $contact): void
    {
        (new DestroyContact(
            user: $user,
            vault: $vault,
            contact: $contact,
        ))->execute();

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);

        $this->assertDatabaseHas('vaults', [
            'id' => $vault->id,
        ]);
    }
}
