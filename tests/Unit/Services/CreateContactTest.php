<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\Gender;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateContact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_contact(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $gender);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $gender);
    }

    #[Test]
    public function it_fails_if_user_doesnt_have_right_permission_in_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_VIEW, $vault);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $gender);
    }

    #[Test]
    public function it_fails_if_gender_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_VIEW, $vault);
        $gender = Gender::factory()->create();
        $this->executeService($user, $vault, $gender);
    }

    private function executeService(User $user, Vault $vault, Gender $gender): void
    {
        $contact = (new CreateContact(
            vault: $vault,
            user: $user,
            gender: $gender,
            firstName: 'Ross',
            lastName: 'Geller',
            middleName: '',
            nickname: '',
            maidenName: '',
            prefix: '',
            suffix: '',
            canBeDeleted: true,
        ))->execute();

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'vault_id' => $vault->id,
            'gender_id' => $gender->id,
            'can_be_deleted' => true,
        ]);

        $this->assertInstanceOf(
            Contact::class,
            $contact
        );
    }
}
