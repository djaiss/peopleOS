<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\SpecialDate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LifeEventTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $lifeEvent = LifeEvent::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($lifeEvent->account()->exists());
    }

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $lifeEvent = LifeEvent::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($lifeEvent->person()->exists());
    }

    #[Test]
    public function it_belongs_to_a_special_date(): void
    {
        $specialDate = SpecialDate::factory()->create();
        $lifeEvent = LifeEvent::factory()->create([
            'special_date_id' => $specialDate->id,
        ]);

        $this->assertTrue($lifeEvent->specialDate()->exists());
    }
}
