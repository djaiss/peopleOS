<?php

namespace Tests\Unit\Models;

use App\Models\Child;
use App\Models\Contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_contact()
    {
        $child = Child::factory()->create();
        $this->assertTrue($child->contact()->exists());
    }

    #[Test]
    public function it_returns_name_if_set()
    {
        $child = Child::factory()->create([
            'name' => 'John',
            'gender' => Contact::GENDER_FEMALE,
        ]);

        $child->refresh();

        $this->assertEquals('John', $child->name);
    }

    #[Test]
    public function it_returns_gender_if_name_not_set()
    {
        $child = Child::factory()->create([
            'name' => null,
            'gender' => Contact::GENDER_FEMALE,
        ]);

        $child->refresh();

        $this->assertEquals('a girl', $child->name);
    }
}
