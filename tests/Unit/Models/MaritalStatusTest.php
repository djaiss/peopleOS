<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\MaritalStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MaritalStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($maritalStatus->account()->exists());
    }
}
