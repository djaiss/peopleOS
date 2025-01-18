<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Gender;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($person->account()->exists());
    }

    #[Test]
    public function it_belongs_to_one_gender(): void
    {
        $gender = Gender::factory()->create();
        $person = Person::factory()->create([
            'gender_id' => $gender->id,
        ]);

        $this->assertTrue($person->gender()->exists());
    }

    #[Test]
    public function it_gets_the_name(): void
    {
        $person = Person::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $this->assertEquals(
            'Ross Geller',
            $person->name
        );
    }
}
