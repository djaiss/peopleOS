<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\SpecialDate;
use App\Services\StopSendingReminder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StopSendingReminderTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_stops_sending_reminders()
    {
        $specialDate = SpecialDate::factory()->create([
            'should_be_reminded' => true,
        ]);

        (new StopSendingReminder(
            specialDate: $specialDate)
        )->execute();

        $this->assertFalse($specialDate->fresh()->should_be_reminded);
    }
}
