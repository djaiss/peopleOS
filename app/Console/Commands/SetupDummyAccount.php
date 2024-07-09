<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Vault;
use App\Services\CreateAccount;
use App\Services\CreateContact;
use App\Services\CreateVault;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class SetupDummyAccount extends Command
{
    use ConfirmableTrait;

    protected ?\Faker\Generator $faker;

    protected User $firstUser;

    protected User $secondUser;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monica:dummy
                            {--migrate : Use migrate command instead of migrate:fresh.}
                            {--force : Force the operation to run.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare an account with fake data so users can play with it';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // remove queue
        config(['queue.default' => 'sync']);

        $this->start();
        $this->wipeAndMigrateDB();
        $this->createFirstUsers();
        $this->createVaults();
        $this->createContacts();
        $this->stop();
    }

    private function start(): void
    {
        if (! $this->confirmToProceed('Are you sure you want to proceed? This will delete ALL data in your environment.', true)) {
            exit;
        }

        $this->line('This process will take a few minutes to complete. Be patient and read a book in the meantime.');
        $this->faker = Faker::create();
    }

    private function wipeAndMigrateDB(): void
    {
        if ($this->option('migrate')) {
            $this->artisan('☐ Migration of the database', 'migrate', ['--force' => true]);
        } else {
            $this->artisan('☐ Migration of the database', 'migrate:fresh', ['--force' => true]);
        }
    }

    private function stop(): void
    {
        $this->line('');
        $this->line('-----------------------------');
        $this->line('|');
        $this->line('| Welcome to Monica');
        $this->line('|');
        $this->line('-----------------------------');
        $this->info('| You can now sign in with one of these two accounts:');
        $this->line('| An account with a lot of data:');
        $this->line('| username: admin@admin.com');
        $this->line('| password: admin123');
        $this->line('|----------------------------');
        $this->line('|A blank account:');
        $this->line('| username: blank@blank.com');
        $this->line('| password: blank123');
        $this->line('|----------------------------');
        $this->line('| URL:      '.config('app.url'));
        $this->line('-----------------------------');

        $this->info('Setup is done. Have fun.');
    }

    private function createFirstUsers(): void
    {
        $this->info('☐ Create first user of the account');

        $this->firstUser = (new CreateAccount(
            email: 'admin@admin.com',
            password: 'admin123',
            firstName: 'Michael',
            lastName: 'Scott',
        ))->execute();
        $this->firstUser->email_verified_at = Carbon::now();
        $this->firstUser->save();
    }

    private function createVaults(): void
    {
        $this->info('☐ Create vaults');

        for ($i = 0; $i < rand(3, 5); $i++) {
            (new CreateVault(
                user: $this->firstUser,
                name: $this->faker->firstName,
                description: rand(1, 2) == 1 ? $this->faker->sentence() : null,
            ))->execute();
        }
    }

    private function createContacts(): void
    {
        $this->info('☐ Create contacts');

        foreach (Vault::all() as $vault) {
            for ($i = 0; $i < rand(300, 2010); $i++) {
                $date = $this->faker->dateTimeThisCentury();
                $birthDate = Carbon::parse($date);

                $contact = (new CreateContact(
                    vault: $vault,
                    user: $this->firstUser,
                    firstName: $this->faker->firstName(),
                    lastName: $this->faker->lastName(),
                    middleName: rand(1, 2) == 1 ? $this->faker->lastName() : null,
                    nickname: null,
                    maidenName: null,
                    prefix: null,
                    suffix: null,
                ))->execute();
            }
        }
    }

    private function artisan(string $message, string $command, array $arguments = []): void
    {
        $this->info($message);
        $this->callSilent($command, $arguments);
    }
}
