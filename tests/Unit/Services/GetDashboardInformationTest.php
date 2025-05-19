<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use App\Services\GetDashboardInformation;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetDashboardInformationTest extends TestCase
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

        $service = (new GetDashboardInformation(
            user: $user,
        ))->getReminders();

        $this->assertCount(2, $service);
        $this->assertEquals('Birthday', $service[0]['name']);
        $this->assertEquals('Anniversary', $service[1]['name']);
    }

    #[Test]
    public function it_should_return_an_inspirational_quote(): void
    {
        $user = User::factory()->create();
        $service = new GetDashboardInformation(user: $user);

        $quote = $service->getInspirationalQuote();

        $this->assertIsString($quote);
        $this->assertNotEmpty($quote);
    }

    #[Test]
    public function it_should_return_latest_seen_persons(): void
    {
        $user = User::factory()->create();

        // Create 7 persons with different last_consulted_at dates
        $persons = collect();
        for ($i = 0; $i < 7; $i++) {
            $persons->push(Person::factory()->create([
                'account_id' => $user->account_id,
                'last_consulted_at' => now()->subHours($i),
            ]));
        }

        $service = new GetDashboardInformation(user: $user);
        $result = $service->getLatestSeenPersons();

        $this->assertCount(5, $result);

        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('slug', $result[0]);
        $this->assertArrayHasKey('avatar', $result[0]);
        $this->assertArrayHasKey('40', $result[0]['avatar']);
        $this->assertArrayHasKey('80', $result[0]['avatar']);
        $this->assertArrayHasKey('last_consulted_at', $result[0]);
    }
}
