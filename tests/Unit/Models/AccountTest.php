<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Log;
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
    public function it_gets_the_avatar(): void
    {
        $account = Account::factory()->create([
            'name' => 'Dunder Mifflin Paper Company',
        ]);

        $this->assertEquals(
            'https://ui-avatars.com/api/?name=D+M+P+C&color=7F9CF5&background=EBF4FF',
            $account->avatar
        );
    }
}
