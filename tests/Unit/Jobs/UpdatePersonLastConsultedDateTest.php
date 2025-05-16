<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\UpdatePersonLastConsultedDate;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePersonLastConsultedDateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_person_last_consulted_date(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $person = Person::factory()->create([
            'last_consulted_at' => null,
        ]);

        UpdatePersonLastConsultedDate::dispatch($person);

        $person->refresh();

        $this->assertNotNull($person->last_consulted_at);
        $this->assertEqualsWithDelta(
            now(),
            $person->last_consulted_at,
            1 // Delta of 1 second
        );
    }
}
