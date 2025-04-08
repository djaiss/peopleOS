<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\DeleteInactiveAccounts;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteInactiveAccountsTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_deletes_inactive_accounts(): void
    {
        Carbon::createFromDate(2011, 8, 19)->setTestNow();

        $account = Account::factory()->create([
            'auto_delete_account' => true,
        ]);
        Account::factory()->create([
            'auto_delete_account' => false,
        ]);

        DeleteInactiveAccounts::dispatch();

        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id,
        ]);

        $this->assertCount(1, Account::all());
    }
}
