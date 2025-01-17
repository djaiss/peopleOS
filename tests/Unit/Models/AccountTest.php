<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Gender;
use App\Models\Log;
use App\Models\MaritalStatus;
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
    public function it_has_many_teams(): void
    {
        $account = Account::factory()->create();
        Team::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->teams()->exists());
    }
}
