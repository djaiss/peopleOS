<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $team = Team::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($team->account()->exists());
    }

    #[Test]
    public function it_belongs_to_many_users(): void
    {
        $team = Team::factory()->create();
        $user = User::factory()->create();
        $team->users()->attach($user);
        $this->assertTrue($team->users()->exists());
    }
}
