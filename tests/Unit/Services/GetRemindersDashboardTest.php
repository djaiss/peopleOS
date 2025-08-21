<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use App\Services\GetDashboardInformation;
use App\Services\GetRemindersDashboard;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetRemindersDashboardTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_return_reminders_for_the_next_30_days(): void
    {
        Carbon::setTestNow(Carbon::parse('2024-03-17 10:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        // Create a reminder for today
        $todayReminder = SpecialDate::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'month' => 3,
            'day' => 18,
            'should_be_reminded' => true,
            'name' => 'Birthday',
        ]);

        // Create a reminder for next month
        $nextMonthReminder = SpecialDate::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'month' => 4,
            'day' => 15,
            'should_be_reminded' => true,
            'name' => 'Anniversary',
        ]);

        // Create a reminder for last month (should not be included)
        $lastMonthReminder = SpecialDate::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'month' => 2,
            'day' => 15,
            'should_be_reminded' => true,
            'name' => 'Old Event',
        ]);

        $service = (new GetRemindersDashboard(
            user: $user,
        ))->execute();

        $this->assertCount(2, $service);
        $this->assertEquals('Birthday', $service[0]['name']);
        $this->assertEquals('Anniversary', $service[1]['name']);
    }
}
