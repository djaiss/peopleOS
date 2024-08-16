<?php

namespace Tests\Unit\Services;

use App\Models\Child;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateChild;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_child(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $contact);
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

    private function executeService(User $user, Contact $contact): void
    {
        $child = (new CreateChild(
            user: $user,
            contact: $contact,
            gender: 'male',
            name: 'Regis',
        ))->execute();

        $this->assertDatabaseHas('children', [
            'id' => $child->id,
            'contact_id' => $contact->id,
        ]);

        $this->assertInstanceOf(
            Child::class,
            $child
        );
    }
}
