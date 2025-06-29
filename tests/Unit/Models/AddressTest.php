<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Address;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $address = Address::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($address->account()->exists());
    }

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $address = Address::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($address->person()->exists());
    }
}
