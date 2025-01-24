<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateAccount;
use App\Services\CreateNote;
use App\Services\CreatePerson;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class SetupDummyAccount extends Command
{
    use ConfirmableTrait;

    protected ?\Faker\Generator $faker = null;

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
        $this->createPersons();
        $this->createSecondBlankUser();
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
        $this->line('| Welcome to PeopleOS');
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
            firstName: 'Monica',
            lastName: 'Geller',
        ))->execute();
        $this->firstUser->email_verified_at = Carbon::now();
        $this->firstUser->save();
    }

    private function createPersons(): void
    {
        $this->info('☐ Create persons');

        $theOfficeCharacters = [
            [
                'first_name' => 'Dwight',
                'last_name' => 'Schrute',
                'nickname' => 'The Dwight',
                'maiden_name' => 'Schrute',
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
                'nickname' => 'The Jim',
                'maiden_name' => 'Halpert',
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
                'nickname' => 'The Pam',
                'maiden_name' => 'Beesly',
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
                'nickname' => 'The Ryan',
                'maiden_name' => 'Howard',
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
                'nickname' => 'The Andy',
                'maiden_name' => 'Bernard',
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
                'nickname' => 'The Stanley',
                'maiden_name' => 'Hudson',
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
                'nickname' => 'The Kevin',
                'maiden_name' => 'Malone',
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
                'nickname' => 'The Angela',
                'maiden_name' => 'Martin',
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
                'nickname' => 'The Oscar',
                'maiden_name' => 'Martinez',
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
                'nickname' => 'The Toby',
                'maiden_name' => 'Flenderson',
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
                'nickname' => 'The Creed',
                'maiden_name' => 'Bratton',
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
                'nickname' => 'The Meredith',
                'maiden_name' => 'Palmer',
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
                'nickname' => 'The Phyllis',
                'maiden_name' => 'Vance',
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
                'nickname' => 'The Kelly',
                'maiden_name' => 'Kapoor',
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
                'nickname' => 'The Darryl',
                'maiden_name' => 'Philbin',
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
                'nickname' => 'The Leslie',
                'maiden_name' => 'Knope',
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
                'nickname' => 'The Ron',
                'maiden_name' => 'Swanson',
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
                'nickname' => 'The Tom',
                'maiden_name' => 'Haverford',
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
                'nickname' => 'The April',
                'maiden_name' => 'Ludgate',
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
                'nickname' => 'The Andy',
                'maiden_name' => 'Dwyer',
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
                'nickname' => 'The Ann',
                'maiden_name' => 'Perkins',
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
                'nickname' => 'The Ben',
                'maiden_name' => 'Wyatt',
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
                'nickname' => 'The Chris',
                'maiden_name' => 'Traeger',
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
                'nickname' => 'The Donna',
                'maiden_name' => 'Meagle',
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
                'nickname' => 'The Jerry',
                'maiden_name' => 'Gergich',
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
                'nickname' => 'The Mark',
                'maiden_name' => 'Brendanawicz',
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
                'nickname' => 'The Rachel',
                'maiden_name' => 'Green',
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
                'nickname' => 'The Monica',
                'maiden_name' => 'Geller',
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
                'nickname' => 'The Phoebe',
                'maiden_name' => 'Buffay',
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
                'nickname' => 'The Joey',
                'maiden_name' => 'Tribbiani',
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
                'nickname' => 'The Chandler',
                'maiden_name' => 'Bing',
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
                'nickname' => 'The Ross',
                'maiden_name' => 'Geller',
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

        foreach ($theOfficeCharacters as $character) {
            $this->createPerson($character);
        }

        foreach ($parksAndRecCharacters as $character) {
            $this->createPerson($character);
        }

        foreach ($friendsCharacters as $character) {
            $this->createPerson($character);
        }
    }

    private function createPerson(array $character): void
    {
        $person = (new CreatePerson(
            user: $this->firstUser,
            gender: Gender::inRandomOrder()->first(),
            firstName: $character['first_name'],
            lastName: $character['last_name'],
            middleName: null,
            nickname: $character['nickname'],
            maidenName: $character['maiden_name'],
            prefix: null,
            suffix: null,
            canBeDeleted: false,
        ))->execute();

        $this->createNotes($person);
    }

    private function createNotes(Person $person): void
    {
        for ($i = 0; $i < random_int(0, 93); $i++) {
            $note = (new CreateNote(
                user: $this->firstUser,
                person: $person,
                content: $this->faker->paragraphs(random_int(1, 3), true)
            ))->execute();
        }
    }

    private function createSecondBlankUser(): void
    {
        $this->secondUser = (new CreateAccount(
            email: 'blank@blank.com',
            password: 'blank123',
            firstName: 'Rachel',
            lastName: 'Green',
        ))->execute();

        $this->secondUser->email_verified_at = Carbon::now();
        $this->secondUser->save();
    }

    private function artisan(string $message, string $command, array $arguments = []): void
    {
        $this->info($message);
        $this->callSilent($command, $arguments);
    }
}
