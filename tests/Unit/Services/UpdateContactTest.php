<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\User;
use App\Models\Vault;
use App\Services\UpdateContact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_contact(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $contact, $gender, $ethnicity);
    }

    #[Test]
    public function it_fails_if_contact_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $contact, $gender, $ethnicity);
    }

    #[Test]
    public function it_fails_if_contact_doesnt_belong_to_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create([
            'account_id' => $vault->account_id,
        ]);
        $contact = Contact::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $contact, $gender, $ethnicity);
    }

    #[Test]
    public function it_fails_if_gender_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $gender = Gender::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $contact, $gender, $ethnicity);
    }

    #[Test]
    public function it_fails_if_ethnicity_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $ethnicity = Ethnicity::factory()->create();
        $this->executeService($user, $vault, $contact, $gender, $ethnicity);
    }

    private function executeService(User $user, Vault $vault, Contact $contact, Gender $gender, ?Ethnicity $ethnicity = null): void
    {
        $contact = (new UpdateContact(
            user: $user,
            contact: $contact,
            gender: $gender,
            ethnicity: $ethnicity,
            nationality: 'American',
            firstName: 'Ross',
            lastName: 'Geller',
            middleName: '',
            nickname: '',
            maidenName: '',
            patronymicName: '',
            tribalName: '',
            generationName: '',
            romanizedName: '',
            prefix: '',
            suffix: '',
            canBeDeleted: true,
        ))->execute();

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'vault_id' => $vault->id,
            'gender_id' => $gender->id,
            'ethnicity_id' => $ethnicity?->id,
            'can_be_deleted' => true,
        ]);

        $this->assertInstanceOf(
            Contact::class,
            $contact
        );
    }
}
