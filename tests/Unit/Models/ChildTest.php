<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Child;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $child = Child::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($child->account()->exists());
    }

    #[Test]
    public function it_belongs_to_a_parent(): void
    {
        $parent = Person::factory()->create();
        $child = Child::factory()->create([
            'parent_id' => $parent->id,
        ]);

        $this->assertTrue($child->parent()->exists());
    }

    #[Test]
    public function it_belongs_to_a_second_parent(): void
    {
        $secondParent = Person::factory()->create();
        $child = Child::factory()->create([
            'second_parent_id' => $secondParent->id,
        ]);

        $this->assertTrue($child->secondParent()->exists());
    }

    #[Test]
    public function it_gets_the_name(): void
    {
        $child = Child::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $this->assertEquals(
            'Ross Geller',
            $child->name,
        );
    }
}
