<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Child;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $child = Child::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($child->person()->exists());
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
    public function it_can_have_null_second_parent(): void
    {
        $child = Child::factory()->create([
            'second_parent_id' => null,
        ]);

        $this->assertNull($child->second_parent_id);
        $this->assertFalse($child->secondParent()->exists());
    }

    #[Test]
    public function it_can_have_null_parent(): void
    {
        $child = Child::factory()->create([
            'parent_id' => null,
        ]);

        $this->assertNull($child->parent_id);
        $this->assertFalse($child->parent()->exists());
    }
}
