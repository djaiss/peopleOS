<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Services\CreateAccount;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user with demo data
        $adminUser = (new CreateAccount(
            email: 'admin@admin.com',
            password: 'admin123',
            firstName: 'Monica',
            lastName: 'Geller',
        ))->execute();
        $adminUser->email_verified_at = Carbon::now();
        $adminUser->save();

        // Create blank user for clean testing
        $blankUser = (new CreateAccount(
            email: 'blank@blank.com',
            password: 'blank123',
            firstName: 'Rachel',
            lastName: 'Green',
        ))->execute();
        $blankUser->email_verified_at = Carbon::now();
        $blankUser->save();
    }
}
