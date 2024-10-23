<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateContactPhoneNumber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateContactPhoneNumberTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_contact_phone_number()
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
    public function it_fails_if_user_and_contact_dont_belong_to_same_account()
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $this->executeService($user, $contact);
    }

    private function executeService(User $user, Contact $contact): void
    {
        $contactPhoneNumber = (new CreateContactPhoneNumber(
            user: $user,
            contact: $contact,
            label: 'Home',
            phoneNumber: '1234567890',
        ))->execute();

        $this->assertDatabaseHas('contact_phone_numbers', [
            'id' => $contactPhoneNumber->id,
            'contact_id' => $contact->id,
        ]);

        $this->assertInstanceOf(
            ContactPhoneNumber::class,
            $contactPhoneNumber
        );
    }
}
