<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Child;
use App\Models\Gender;
use App\Models\Person;
use App\Models\SpecialDate;
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
    public function it_belongs_to_an_age_special_date(): void
    {
        $ageSpecialDate = SpecialDate::factory()->create();
        $child = Child::factory()->create([
            'age_special_date_id' => $ageSpecialDate->id,
        ]);

        $this->assertTrue($child->ageSpecialDate()->exists());
    }

    #[Test]
    public function it_belongs_to_a_gender(): void
    {
        $gender = Gender::factory()->create();
        $child = Child::factory()->create([
            'gender_id' => $gender->id,
        ]);

        $this->assertTrue($child->gender()->exists());
    }
}