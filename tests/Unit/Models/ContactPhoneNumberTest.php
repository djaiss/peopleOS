<?php

namespace Tests\Unit\Models;

use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactPhoneNumberTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_contact(): void
    {
        $contactPhoneNumber = ContactPhoneNumber::factory()->create();
        $this->assertTrue($contactPhoneNumber->contact()->exists());
    }
}
