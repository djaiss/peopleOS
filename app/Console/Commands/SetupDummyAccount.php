<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateAccount;
use App\Services\CreateCompany;
use App\Services\CreateContact;
use App\Services\CreateNote;
use App\Services\CreateVault;
use App\Services\UpdateJobInformation;
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
    protected $signature = 'peopleos:dummy
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
        $this->createCompanies();
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

    private function createCompanies(): void
    {
        $this->info('☐ Create companies');

        foreach (Vault::all() as $vault) {
            for ($i = 0; $i < rand(10, 50); $i++) {
                (new CreateCompany(
                    vault: $vault,
                    user: $this->firstUser,
                    name: $this->faker->company,
                ))->execute();
            }
        }
    }

    private function createContacts(): void
    {
        $this->info('☐ Create contacts');

        $officeCharacters = [
            [
                'first_name' => 'Dwight',
                'last_name' => 'Schrute',
                'profession' => 'Assistant to the Regional Manager',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Hired as Assistant to the Regional Manager',
                'birthdate' => 'January 20, 1970',
                'spouse' => [
                    'first_name' => 'Angela',
                    'last_name' => 'Martin',
                    'birthdate' => 'November 11, 1971',
                ],
                'children' => [
                    [
                        'first_name' => 'Philip',
                        'last_name' => 'Schrute',
                        'birthdate' => '2013',
                    ],
                ],
            ],
            [
                'first_name' => 'Jim',
                'last_name' => 'Halpert',
                'profession' => 'Sales Representative',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Interviewed and hired at Dunder Mifflin',
                'birthdate' => 'October 1, 1978',
                'spouse' => [
                    'first_name' => 'Pam',
                    'last_name' => 'Beesly',
                    'birthdate' => 'March 25, 1979',
                ],
                'children' => [
                    [
                        'first_name' => 'Cecelia',
                        'last_name' => 'Halpert',
                        'birthdate' => 'March 4, 2010',
                    ],
                    [
                        'first_name' => 'Philip',
                        'last_name' => 'Halpert',
                        'birthdate' => 'December 2011',
                    ],
                ],
            ],
            [
                'first_name' => 'Pam',
                'last_name' => 'Beesly',
                'profession' => 'Receptionist',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Already working as the receptionist when Michael became manager',
                'birthdate' => 'March 25, 1979',
                'spouse' => [
                    'first_name' => 'Jim',
                    'last_name' => 'Halpert',
                    'birthdate' => 'October 1, 1978',
                ],
                'children' => [
                    [
                        'first_name' => 'Cecelia',
                        'last_name' => 'Halpert',
                        'birthdate' => 'March 4, 2010',
                    ],
                    [
                        'first_name' => 'Philip',
                        'last_name' => 'Halpert',
                        'birthdate' => 'December 2011',
                    ],
                ],
            ],
            [
                'first_name' => 'Ryan',
                'last_name' => 'Howard',
                'profession' => 'Temp',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Met as a temp hired by the company',
                'birthdate' => 'May 5, 1980',
                'spouse' => null,
                'children' => null,
            ],
            [
                'first_name' => 'Andy',
                'last_name' => 'Bernard',
                'profession' => 'Sales Representative',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Transferred from the Stamford branch',
                'birthdate' => 'July 31, 1973',
                'spouse' => null,
                'children' => null,
            ],
            [
                'first_name' => 'Stanley',
                'last_name' => 'Hudson',
                'profession' => 'Sales Representative',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Working at Dunder Mifflin since Michael became manager',
                'birthdate' => 'February 19, 1951',
                'spouse' => [
                    'first_name' => 'Teri',
                    'last_name' => 'Hudson',
                    'birthdate' => 'July 15, 1955',
                ],
                'children' => [
                    [
                        'first_name' => 'Melissa',
                        'last_name' => 'Hudson',
                        'birthdate' => '1990',
                    ],
                ],
            ],
            [
                'first_name' => 'Kevin',
                'last_name' => 'Malone',
                'profession' => 'Accountant',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Already working in accounting when Michael became manager',
                'birthdate' => 'June 1, 1968',
                'spouse' => null,
                'children' => null,
            ],
            [
                'first_name' => 'Angela',
                'last_name' => 'Martin',
                'profession' => 'Accountant',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Head of the Party Planning Committee',
                'birthdate' => 'November 11, 1971',
                'spouse' => [
                    'first_name' => 'Dwight',
                    'last_name' => 'Schrute',
                    'birthdate' => 'January 20, 1970',
                ],
                'children' => [
                    [
                        'first_name' => 'Philip',
                        'last_name' => 'Schrute',
                        'birthdate' => '2013',
                    ],
                ],
            ],
            [
                'first_name' => 'Oscar',
                'last_name' => 'Martinez',
                'profession' => 'Accountant',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Already working in accounting when Michael became manager',
                'birthdate' => 'February 19, 1968',
                'spouse' => null,
                'children' => null,
            ],
            [
                'first_name' => 'Toby',
                'last_name' => 'Flenderson',
                'profession' => 'HR Representative',
                'company' => 'Dunder Mifflin',
                'meeting' => 'HR representative from corporate',
                'birthdate' => 'February 22, 1969',
                'spouse' => null,
                'children' => [
                    [
                        'first_name' => 'Sasha',
                        'last_name' => 'Flenderson',
                        'birthdate' => '2005',
                    ],
                ],
            ],
            [
                'first_name' => 'Creed',
                'last_name' => 'Bratton',
                'profession' => 'Quality Assurance Director',
                'company' => 'Dunder Mifflin',
                'meeting' => "Worked at Dunder Mifflin long before Michael's tenure",
                'birthdate' => 'November 1, 1943',
                'spouse' => null,
                'children' => null,
            ],
            [
                'first_name' => 'Meredith',
                'last_name' => 'Palmer',
                'profession' => 'Supplier Relations',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Customer Service Representative at Dunder Mifflin',
                'birthdate' => 'July 11, 1961',
                'spouse' => null,
                'children' => [
                    [
                        'first_name' => 'Jake',
                        'last_name' => 'Palmer',
                        'birthdate' => '1995',
                    ],
                ],
            ],
            [
                'first_name' => 'Phyllis',
                'last_name' => 'Vance',
                'profession' => 'Sales Representative',
                'company' => 'Dunder Mifflin',
                'meeting' => "Worked at Dunder Mifflin long before Michael's tenure",
                'birthdate' => 'July 10, 1951',
                'spouse' => [
                    'first_name' => 'Bob',
                    'last_name' => 'Vance',
                    'birthdate' => 'March 16, 1948',
                ],
                'children' => null,
            ],
            [
                'first_name' => 'Kelly',
                'last_name' => 'Kapoor',
                'profession' => 'Customer Service Representative',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Customer Service Representative at Dunder Mifflin',
                'birthdate' => 'February 5, 1980',
                'spouse' => null,
                'children' => null,
            ],
            [
                'first_name' => 'Darryl',
                'last_name' => 'Philbin',
                'profession' => 'Warehouse Foreman',
                'company' => 'Dunder Mifflin',
                'meeting' => 'Met in the warehouse, Darryl was the warehouse foreman',
                'birthdate' => 'August 20, 1971',
                'spouse' => null,
                'children' => [
                    [
                        'first_name' => 'Jada',
                        'last_name' => 'Philbin',
                        'birthdate' => '2003',
                    ],
                ],
            ],
        ];

        $parksAndRecCharacters = [
            [
                'first_name' => 'Leslie',
                'last_name' => 'Knope',
                'profession' => 'Deputy Director',
                'company' => 'Parks and Recreation Department',
                'meeting' => 'Self',
                'birthdate' => 'January 18, 1975',
                'spouse' => [
                    'first_name' => 'Ben',
                    'last_name' => 'Wyatt',
                    'birthdate' => 'November 14, 1974',
                ],
                'children' => [
                    [
                        'first_name' => 'Stephen',
                        'last_name' => 'Wyatt',
                        'birthdate' => '2014',
                    ],
                    [
                        'first_name' => 'Sonia',
                        'last_name' => 'Wyatt',
                        'birthdate' => '2014',
                    ],
                ],
            ],
            [
                'first_name' => 'Ron',
                'last_name' => 'Swanson',
                'profession' => 'Director',
                'company' => 'Parks and Recreation Department',
                'meeting' => 'Worked together in the Parks Department',
                'birthdate' => 'May 6, 1967',
                'spouse' => [
                    'first_name' => 'Diane',
                    'last_name' => 'Lewis',
                    'birthdate' => 'March 5, 1969',
                ],
                'children' => [
                    [
                        'first_name' => 'John',
                        'last_name' => 'Swanson',
                        'birthdate' => 'October 2013',
                    ],
                    [
                        'first_name' => 'Jane',
                        'last_name' => 'Swanson',
                        'birthdate' => 'October 2013',
                    ],
                ],
            ],
            [
                'first_name' => 'Tom',
                'last_name' => 'Haverford',
                'profession' => 'Administrator',
                'company' => 'Parks and Recreation Department',
                'meeting' => 'Worked together in the Parks Department',
                'birthdate' => 'April 26, 1985',
                'spouse' => null,
                'children' => null,
            ],
            [
                'first_name' => 'April',
                'last_name' => 'Ludgate',
                'profession' => 'Intern',
                'company' => 'Parks and Recreation Department',
                'meeting' => 'Hired as an intern in the Parks Department',
                'birthdate' => 'February 29, 1988',
                'spouse' => [
                    'first_name' => 'Andy',
                    'last_name' => 'Dwyer',
                    'birthdate' => 'August 31, 1979',
                ],
                'children' => [
                    [
                        'first_name' => 'Jack',
                        'last_name' => 'Dwyer',
                        'birthdate' => '2017',
                    ],
                ],
            ],
            [
                'first_name' => 'Andy',
                'last_name' => 'Dwyer',
                'profession' => 'Shoe Shiner / Musician',
                'company' => 'City Hall / Mouse Rat',
                'meeting' => 'Met through Ann Perkins and his job at City Hall',
                'birthdate' => 'August 31, 1979',
                'spouse' => [
                    'first_name' => 'April',
                    'last_name' => 'Ludgate',
                    'birthdate' => 'February 29, 1988',
                ],
                'children' => [
                    [
                        'first_name' => 'Jack',
                        'last_name' => 'Dwyer',
                        'birthdate' => '2017',
                    ],
                ],
            ],
            [
                'first_name' => 'Ann',
                'last_name' => 'Perkins',
                'profession' => 'Nurse',
                'company' => 'Pawnee Medical Center',
                'meeting' => 'Met through a town hall meeting about the pit behind her house',
                'birthdate' => 'April 2, 1976',
                'spouse' => null,
                'children' => [
                    [
                        'first_name' => 'Oliver',
                        'last_name' => 'Perkins',
                        'birthdate' => 'December 2014',
                    ],
                ],
            ],
            [
                'first_name' => 'Ben',
                'last_name' => 'Wyatt',
                'profession' => 'State Auditor',
                'company' => 'Indiana State Government',
                'meeting' => 'Sent to Pawnee to help fix the budget crisis',
                'birthdate' => 'November 14, 1974',
                'spouse' => [
                    'first_name' => 'Leslie',
                    'last_name' => 'Knope',
                    'birthdate' => 'January 18, 1975',
                ],
                'children' => [
                    [
                        'first_name' => 'Stephen',
                        'last_name' => 'Wyatt',
                        'birthdate' => '2014',
                    ],
                    [
                        'first_name' => 'Sonia',
                        'last_name' => 'Wyatt',
                        'birthdate' => '2014',
                    ],
                ],
            ],
            [
                'first_name' => 'Chris',
                'last_name' => 'Traeger',
                'profession' => 'City Manager',
                'company' => 'Pawnee City Government',
                'meeting' => 'Sent to Pawnee to help fix the budget crisis',
                'birthdate' => 'October 5, 1966',
                'spouse' => [
                    'first_name' => 'Millicent',
                    'last_name' => 'Gergich',
                    'birthdate' => 'March 12, 1987',
                ],
                'children' => [
                    [
                        'first_name' => 'Jonathan',
                        'last_name' => 'Traeger',
                        'birthdate' => 'December 2015',
                    ],
                ],
            ],
            [
                'first_name' => 'Donna',
                'last_name' => 'Meagle',
                'profession' => 'Office Manager',
                'company' => 'Parks and Recreation Department',
                'meeting' => 'Worked together in the Parks Department',
                'birthdate' => 'March 18, 1971',
                'spouse' => [
                    'first_name' => 'Joe',
                    'last_name' => 'Langman',
                    'birthdate' => 'May 5, 1968',
                ],
                'children' => null,
            ],
            [
                'first_name' => 'Jerry',
                'last_name' => 'Gergich',
                'profession' => 'Public Relations Director',
                'company' => 'Parks and Recreation Department',
                'meeting' => 'Worked together in the Parks Department',
                'birthdate' => 'February 29, 1948',
                'spouse' => [
                    'first_name' => 'Gayle',
                    'last_name' => 'Gergich',
                    'birthdate' => 'July 18, 1954',
                ],
                'children' => [
                    [
                        'first_name' => 'Millicent',
                        'last_name' => 'Gergich',
                        'birthdate' => 'March 12, 1987',
                    ],
                    [
                        'first_name' => 'Miriam',
                        'last_name' => 'Gergich',
                        'birthdate' => 'August 7, 1989',
                    ],
                    [
                        'first_name' => 'Gladys',
                        'last_name' => 'Gergich',
                        'birthdate' => 'January 9, 1993',
                    ],
                ],
            ],
            [
                'first_name' => 'Mark',
                'last_name' => 'Brendanawicz',
                'profession' => 'City Planner',
                'company' => 'Pawnee City Government',
                'meeting' => 'Worked together in the City Government',
                'birthdate' => 'January 3, 1975',
                'spouse' => null,
                'children' => null,
            ],
        ];

        $friendsCharacters = [
            [
                'first_name' => 'Rachel',
                'last_name' => 'Green',
                'profession' => 'Fashion Executive',
                'company' => 'Ralph Lauren',
                'meeting' => 'Met Monica in high school, reconnected when she ran out on her wedding',
                'birthdate' => 'May 5, 1970',
                'spouse' => [
                    'first_name' => 'Ross',
                    'last_name' => 'Geller',
                    'birthdate' => 'October 18, 1967',
                ],
                'children' => [
                    [
                        'first_name' => 'Emma',
                        'last_name' => 'Geller-Green',
                        'birthdate' => 'May 16, 2002',
                    ],
                ],
            ],
            [
                'first_name' => 'Monica',
                'last_name' => 'Geller',
                'profession' => 'Chef',
                'company' => 'Javu',
                'meeting' => 'Met Rachel in high school, met the rest through her brother Ross and living in NYC',
                'birthdate' => 'April 22, 1969',
                'spouse' => [
                    'first_name' => 'Chandler',
                    'last_name' => 'Bing',
                    'birthdate' => 'April 8, 1968',
                ],
                'children' => [
                    [
                        'first_name' => 'Jack',
                        'last_name' => 'Bing',
                        'birthdate' => 'May 2004',
                    ],
                    [
                        'first_name' => 'Erica',
                        'last_name' => 'Bing',
                        'birthdate' => 'May 2004',
                    ],
                ],
            ],
            [
                'first_name' => 'Phoebe',
                'last_name' => 'Buffay',
                'profession' => 'Masseuse/Musician',
                'company' => 'Healing Hands Inc.',
                'meeting' => 'Met Monica while living in NYC, met the rest through her',
                'birthdate' => 'February 16, 1967',
                'spouse' => [
                    'first_name' => 'Mike',
                    'last_name' => 'Hannigan',
                    'birthdate' => 'March 24, 1968',
                ],
                'children' => null,
            ],
            [
                'first_name' => 'Joey',
                'last_name' => 'Tribbiani',
                'profession' => 'Actor',
                'company' => 'Days of Our Lives',
                'meeting' => 'Met Chandler through a roommate ad, met the rest through him',
                'birthdate' => 'January 9, 1968',
                'spouse' => null,
                'children' => null,
            ],
            [
                'first_name' => 'Chandler',
                'last_name' => 'Bing',
                'profession' => 'Statistical Analysis and Data Reconfiguration',
                'company' => 'Transponster Corp.',
                'meeting' => 'Met Ross in college, met the rest through Ross and living in NYC',
                'birthdate' => 'April 8, 1968',
                'spouse' => [
                    'first_name' => 'Monica',
                    'last_name' => 'Geller',
                    'birthdate' => 'April 22, 1969',
                ],
                'children' => [
                    [
                        'first_name' => 'Jack',
                        'last_name' => 'Bing',
                        'birthdate' => 'May 2004',
                    ],
                    [
                        'first_name' => 'Erica',
                        'last_name' => 'Bing',
                        'birthdate' => 'May 2004',
                    ],
                ],
            ],
            [
                'first_name' => 'Ross',
                'last_name' => 'Geller',
                'profession' => 'Paleontologist',
                'company' => 'New York Museum of Prehistoric History',
                'meeting' => 'Met Chandler in college, met the rest through Chandler and his sister Monica',
                'birthdate' => 'October 18, 1967',
                'spouse' => [
                    'first_name' => 'Rachel',
                    'last_name' => 'Green',
                    'birthdate' => 'May 5, 1970',
                ],
                'children' => [
                    [
                        'first_name' => 'Emma',
                        'last_name' => 'Geller-Green',
                        'birthdate' => 'May 16, 2002',
                    ],
                    [
                        'first_name' => 'Ben',
                        'last_name' => 'Geller',
                        'birthdate' => '1995',
                    ],
                ],
            ],
        ];

        foreach (Vault::all() as $vault) {
            foreach ($officeCharacters as $character) {
                $this->createContact($vault, $character);
            }

            foreach ($parksAndRecCharacters as $character) {
                $this->createContact($vault, $character);
            }

            foreach ($friendsCharacters as $character) {
                $this->createContact($vault, $character);
            }
        }
    }

    private function createContact(Vault $vault, $character): void
    {
        $contact = (new CreateContact(
            vault: $vault,
            user: $this->firstUser,
            gender: Gender::inRandomOrder()->first(),
            ethnicity: Ethnicity::inRandomOrder()->first(),
            firstName: $character['first_name'],
            lastName: $character['last_name'],
            middleName: null,
            nickname: null,
            maidenName: null,
            patronymicName: null,
            tribalName: null,
            generationName: null,
            romanizedName: null,
            prefix: null,
            suffix: null,
        ))->execute();

        (new UpdateJobInformation(
            user: $this->firstUser,
            contact: $contact,
            companyName: $character['company'],
            jobTitle: $character['profession'],
        ))->execute();

        $this->createNotes($contact);
    }

    private function createNotes(Contact $contact): void
    {
        for ($i = 0; $i < rand(0, 93); $i++) {
            $note = (new CreateNote(
                user: $this->firstUser,
                contact: $contact,
                body: $this->faker->paragraphs(rand(1, 3), true)
            ))->execute();
        }
    }

    private function artisan(string $message, string $command, array $arguments = []): void
    {
        $this->info($message);
        $this->callSilent($command, $arguments);
    }
}
