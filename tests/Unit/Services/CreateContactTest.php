<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\MaritalStatus;
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
        $vault = $this->createVault($user);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $gender, $ethnicity, $maritalStatus);
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
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $gender, $ethnicity, $maritalStatus);
    }

    #[Test]
    public function it_fails_if_gender_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $gender = Gender::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $gender, $ethnicity, $maritalStatus);
    }

    #[Test]
    public function it_fails_if_ethnicity_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $ethnicity = Ethnicity::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $this->executeService($user, $vault, $gender, $ethnicity, $maritalStatus);
    }

    #[Test]
    public function it_fails_if_marital_status_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $gender = Gender::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create();
        $this->executeService($user, $vault, $gender, $ethnicity, $maritalStatus);
    }

    private function executeService(User $user, Vault $vault, Gender $gender, ?Ethnicity $ethnicity = null, ?MaritalStatus $maritalStatus = null): void
    {
        $contact = (new CreateContact(
            vault: $vault,
            user: $user,
            gender: $gender,
            ethnicity: $ethnicity,
            maritalStatus: $maritalStatus,
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
