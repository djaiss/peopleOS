<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Config::set('queue.default', 'sync');

        $this->command->info('Seeding database with demo data...');
        $this->command->info('This may take a few minutes to complete.');

        // Run seeders in the correct order
        $this->call([
            UserWaitlistSeeder::class,
            UserSeeder::class,
            PersonSeeder::class,
        ]);

        $this->displayLoginInfo();
    }

    private function displayLoginInfo(): void
    {
        $this->command->newLine();
        $this->command->info('-----------------------------');
        $this->command->line('|');
        $this->command->line('| Welcome to PeopleOS');
        $this->command->line('|');
        $this->command->info('-----------------------------');
        $this->command->info('| You can now sign in with one of these two accounts:');
        $this->command->line('| An account with a lot of data:');
        $this->command->line('| username: admin@admin.com');
        $this->command->line('| password: admin123');
        $this->command->line('|----------------------------');
        $this->command->line('| A blank account:');
        $this->command->line('| username: blank@blank.com');
        $this->command->line('| password: blank123');
        $this->command->line('|----------------------------');
        $this->command->line('| URL:      ' . config('app.url'));
        $this->command->info('-----------------------------');
        $this->command->info('Setup is done. Have fun.');
    }
}
