<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\EmailSent;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EmailSentTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $emailSent = EmailSent::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($emailSent->account()->exists());
    }

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $emailSent = EmailSent::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($emailSent->person()->exists());
    }
}
