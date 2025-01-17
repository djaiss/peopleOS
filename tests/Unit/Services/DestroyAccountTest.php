<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Team;
use App\Models\User;
use App\Services\CreateTeam;
use App\Services\DestroyAccount;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyAccountTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_an_account(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        (new DestroyAccount(
            user: $user,
        ))->execute();

        $this->assertDatabaseMissing('accounts', [
            'id' => $user->account_id,
        ]);
    }
}
