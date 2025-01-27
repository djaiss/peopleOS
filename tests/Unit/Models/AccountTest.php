<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Gender;
use App\Models\Log;
use App\Models\MaritalStatus;
use App\Models\Person;
use App\Models\Team;
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
    public function it_has_many_logs(): void
    {
        $account = Account::factory()->create();
        Log::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->logs()->exists());
    }

    #[Test]
    public function it_has_many_genders(): void
    {
        $account = Account::factory()->create();
        Gender::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->genders()->exists());
    }

    #[Test]
    public function it_has_many_marital_statuses(): void
    {
        $account = Account::factory()->create();
        MaritalStatus::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->maritalStatuses()->exists());
    }

    #[Test]
    public function it_has_many_persons(): void
    {
        $account = Account::factory()->create();
        Person::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->persons()->exists());
    }

    #[Test]
    public function it_has_many_teams(): void
    {
        $account = Account::factory()->create();
        Team::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->teams()->exists());
    }

    #[Test]
    public function it_checks_if_the_account_is_in_trial(): void
    {
        config(['peopleos.enable_paid_version' => true]);
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->addDays(30),
        ]);
        $this->assertTrue($account->isInTrial());
    }

    #[Test]
    public function it_checks_if_the_account_needs_to_pay(): void
    {
        config(['peopleos.enable_paid_version' => true]);
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->subMinutes(1),
        ]);
        $this->assertTrue($account->needsToPay());

        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->addMinutes(1),
        ]);
        $this->assertFalse($account->needsToPay());

        $account = Account::factory()->create([
            'has_lifetime_access' => true,
        ]);
        $this->assertFalse($account->needsToPay());

        config(['peopleos.enable_paid_version' => false]);
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->subDays(31),
        ]);
        $this->assertFalse($account->needsToPay());

        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->subDays(29),
        ]);
        $this->assertFalse($account->needsToPay());
    }
}
