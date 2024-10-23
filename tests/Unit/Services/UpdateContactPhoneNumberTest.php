<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use App\Models\User;
use App\Models\Vault;
use App\Services\UpdateContactPhoneNumber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateContactPhoneNumberTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_contact_phone_number(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $contactPhoneNumber = ContactPhoneNumber::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $contactPhoneNumber);
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
        $contactPhoneNumber = ContactPhoneNumber::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $contactPhoneNumber);
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
        $contactPhoneNumber = ContactPhoneNumber::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $contactPhoneNumber);
    }

    #[Test]
    public function it_fails_if_contact_phone_number_doesnt_belong_to_contact(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $contactPhoneNumber = ContactPhoneNumber::factory()->create();
        $this->executeService($user, $contactPhoneNumber);
    }

    private function executeService(User $user, ContactPhoneNumber $contactPhoneNumber): void
    {
        $contactPhoneNumber = (new UpdateContactPhoneNumber(
            user: $user,
            contactPhoneNumber: $contactPhoneNumber,
            label: 'This is awesome',
            phoneNumber: '1234567890',
        ))->execute();

        $this->assertDatabaseHas('contact_phone_numbers', [
            'id' => $contactPhoneNumber->id,
        ]);

        $this->assertInstanceOf(
            ContactPhoneNumber::class,
            $contactPhoneNumber
        );
    }
}
