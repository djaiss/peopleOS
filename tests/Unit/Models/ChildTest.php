<?php

namespace Tests\Unit\Models;

use App\Enums\ChildGender;
use App\Models\Child;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_contact(): void
    {
        $child = Child::factory()->create();
        $this->assertTrue($child->contact()->exists());
    }

    #[Test]
    public function it_returns_the_name_of_the_child(): void
    {
        $child = Child::factory()->create([
            'name' => null,
            'gender' => ChildGender::BOY->value,
        ]);

        $this->assertEquals('a boy', $child->name);

        $child = Child::factory()->create([
            'name' => null,
            'gender' => ChildGender::GIRL->value,
        ]);

        $this->assertEquals('a girl', $child->name);

        $child = Child::factory()->create([
            'name' => 'James',
            'gender' => ChildGender::GIRL->value,
        ]);

        $this->assertEquals('James', $child->name);
    }
}
