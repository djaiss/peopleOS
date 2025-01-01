<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\Template;
use App\Models\User;
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
