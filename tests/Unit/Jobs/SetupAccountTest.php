<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\SetupAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SetupAccountTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_setups_an_account(): void
    {
        $user = User::factory()->create();
        SetupAccount::dispatch($user);

        $this->assertEquals(
            3,
            DB::table('genders')->count()
        );
        $this->assertEquals(
            6,
            DB::table('task_categories')->count()
        );
    }
}
