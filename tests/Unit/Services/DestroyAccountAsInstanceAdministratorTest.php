<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Account;
use App\Models\User;
use App\Services\DestroyAccountAsInstanceAdministrator;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyAccountAsInstanceAdministratorTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_an_account_as_instance_administrator(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        (new DestroyAccountAsInstanceAdministrator(
            user: $user,
            account: $account,
        ))->execute();

        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id,
        ]);
    }

    #[Test]
    public function it_fails_if_user_is_not_instance_administrator(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create([
            'is_instance_admin' => false,
        ]);

        $this->expectException(Exception::class);

        (new DestroyAccountAsInstanceAdministrator(
            user: $user,
            account: $account,
        ))->execute();
    }
}
