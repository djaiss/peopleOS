<?php

namespace Tests\Unit\Models;

use App\Models\Day;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DayTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_journal(): void
    {
        $day = Day::factory()->create();
        $this->assertTrue($day->journal()->exists());
    }

    #[Test]
    public function it_belongs_to_a_template(): void
    {
        $day = Day::factory()->create();
        $this->assertTrue($day->template()->exists());
    }
}
