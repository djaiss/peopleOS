<?php

namespace Tests\Unit\Services;

use App\Models\Child;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use App\Services\DestroyChild;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_child(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $child);
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
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $child);
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
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $child);
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
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $child);
    }

    #[Test]
    public function it_fails_if_note_doesnt_belong_to_contact(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create();
        $this->executeService($user, $child);
    }

    private function executeService(User $user, Child $child): void
    {
        (new DestroyChild(
            user: $user,
            child: $child,
        ))->execute();

        $this->assertDatabaseMissing('children', [
            'id' => $child->id,
        ]);
    }
}
