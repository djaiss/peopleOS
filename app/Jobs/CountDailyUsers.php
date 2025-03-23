<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class CountDailyUsers implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $today = now()->format('Y-m-d');

        if (DB::table('instance_daily_activity')->where('date', $today)->exists()) {
            return;
        }

        $usersCount = User::count();

        DB::table('instance_daily_activity')->insert([
            'date' => $today,
            'users_count' => $usersCount,
        ]);
    }
}
