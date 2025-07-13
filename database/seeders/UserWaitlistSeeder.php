<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserWaitlistStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserWaitlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_waitlist')->insert([
            'email' => Crypt::encryptString('chandler.bing@friends.com'),
            'status' => UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        DB::table('user_waitlist')->insert([
            'email' => Crypt::encryptString('monica.geller@friends.com'),
            'status' => UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value,
            'created_at' => Carbon::now()->subDays(19),
        ]);

        DB::table('user_waitlist')->insert([
            'email' => Crypt::encryptString('ross.geller@friends.com'),
            'status' => UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value,
            'created_at' => Carbon::now()->subDays(1),
        ]);
    }
}
