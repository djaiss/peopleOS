<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\CountDailyUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CountDailyUsersTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_counts_the_daily_users(): void
    {
        Carbon::setTestNow(Carbon::create(2025, 3, 23));

        $user = User::factory()->create();

        CountDailyUsers::dispatch();

        $this->assertDatabaseHas('instance_daily_activity', [
            'date' => '2025-03-23',
            'users_count' => 1,
        ]);
    }

    #[Test]
    public function it_does_not_count_the_daily_users_if_it_already_exists(): void
    {
        Carbon::setTestNow(Carbon::create(2025, 3, 23));

        DB::table('instance_daily_activity')->insert([
            'date' => '2025-03-23',
            'users_count' => 1,
        ]);

        $user = User::factory()->create();

        CountDailyUsers::dispatch();

        $this->assertCount(1, DB::table('instance_daily_activity')->get());
    }
}
