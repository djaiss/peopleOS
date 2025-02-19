<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Person;
use App\Models\PersonSeenReport;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonSeenReportTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $personSeenReport = PersonSeenReport::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($personSeenReport->account()->exists());
    }

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $personSeenReport = PersonSeenReport::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($personSeenReport->person()->exists());
    }
}
