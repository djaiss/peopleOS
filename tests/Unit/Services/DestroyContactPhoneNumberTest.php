<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use App\Models\User;
use App\Models\Vault;
use App\Services\DestroyContactPhoneNumber;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyContactPhoneNumberTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_contact_phone_number(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
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
        $contactPhoneNumber = ContactPhoneNumber::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $contactPhoneNumber);
    }

    private function executeService(User $user, ContactPhoneNumber $contactPhoneNumber): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        (new DestroyContactPhoneNumber(
            user: $user,
            contactPhoneNumber: $contactPhoneNumber,
        ))->execute();

        $this->assertDatabaseMissing('contact_phone_numbers', [
            'id' => $contactPhoneNumber->id,
        ]);
    }
}
