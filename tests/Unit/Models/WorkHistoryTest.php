<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Person;
use App\Models\WorkHistory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class WorkHistoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($workHistory->person()->exists());
    }
}
