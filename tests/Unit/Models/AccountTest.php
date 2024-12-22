<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\AddressType;
use App\Models\CallReasonType;
use App\Models\ContactInformationType;
use App\Models\Currency;
use App\Models\Emotion;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\GiftOccasion;
use App\Models\GiftState;
use App\Models\GroupType;
use App\Models\MaritalStatus;
use App\Models\Module;
use App\Models\PetCategory;
use App\Models\PostTemplate;
use App\Models\Pronoun;
use App\Models\RelationshipGroupType;
use App\Models\Religion;
use App\Models\Template;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_has_many_users(): void
    {
        $account = Account::factory()->create();
        User::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->users()->exists());
    }

    #[Test]
    public function it_has_many_genders(): void
    {
        $account = Account::factory()->create();
        Gender::factory(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->genders()->exists());
    }

    #[Test]
    public function it_has_many_ethnicities(): void
    {
        $account = Account::factory()->create();
        Ethnicity::factory(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->ethnicities()->exists());
    }

    #[Test]
    public function it_has_many_marital_statuses(): void
    {
        $account = Account::factory()->create();
        MaritalStatus::factory(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->maritalStatuses()->exists());
    }

    #[Test]
    public function it_has_many_templates(): void
    {
        $account = Account::factory()->create();
        Template::factory(2)->create([
            'account_id' => $account->id,
        ]);
        $this->assertTrue($account->templates()->exists());
    }
}
