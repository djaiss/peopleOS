<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Person;
use App\Models\SpecialDate;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SpecialDateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $specialDate = SpecialDate::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($specialDate->account()->exists());
    }

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($specialDate->person()->exists());
    }

    #[Test]
    public function it_calculates_age_correctly(): void
    {
        Carbon::setTestNow(Carbon::create(2024, 1, 1));

        // Test with exact date
        $specialDate = SpecialDate::factory()->create([
            'year' => 1994,
            'month' => 6,
            'day' => 15,
        ]);

        $this->assertEquals('29 years ago', $specialDate->age);

        // Test with only year provided
        $specialDate = SpecialDate::factory()->create([
            'year' => 1994,
            'month' => null,
            'day' => null,
        ]);

        $this->assertEquals('30 years ago', $specialDate->age);

        // Test with no year provided
        $specialDate = SpecialDate::factory()->create([
            'year' => null,
            'month' => 6,
            'day' => 15,
        ]);

        $this->assertEquals('Unknown', $specialDate->age);
    }

    #[Test]
    public function it_gets_the_friendly_date(): void
    {
        $specialDate = SpecialDate::factory()->create([
            'year' => 1994,
            'month' => 6,
            'day' => 15,
        ]);

        $this->assertEquals('Jun 15, 1994', $specialDate->date);

        $specialDate = SpecialDate::factory()->create([
            'year' => 1994,
            'month' => null,
            'day' => null,
        ]);

        $this->assertEquals('1994', $specialDate->date);

        $specialDate = SpecialDate::factory()->create([
            'year' => null,
            'month' => 6,
            'day' => 15,
        ]);

        $this->assertEquals('Jun 15', $specialDate->date);

        $specialDate = SpecialDate::factory()->create([
            'year' => null,
            'month' => 0,
            'day' => 15,
        ]);

        $this->assertEquals('15', $specialDate->date);
    }
}
