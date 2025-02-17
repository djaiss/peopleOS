<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessReminders;
use App\Jobs\SendReminder;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProcessRemindersTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_processes_reminders_for_current_date(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        // Create a special date for today
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'month' => now()->month,
            'day' => now()->day,
            'should_be_reminded' => true,
        ]);

        // Create a special date for another day (shouldn't be processed)
        SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'month' => now()->month,
            'day' => now()->day + 1,
            'should_be_reminded' => true,
        ]);

        // Create a special date for today but with reminders disabled
        SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'month' => now()->month,
            'day' => now()->day,
            'should_be_reminded' => false,
        ]);

        $job = new ProcessReminders();
        $job->dispatch();
        $job->handle();

        Queue::assertPushed(SendReminder::class, function (SendReminder $job) use ($specialDate): bool {
            return $job->specialDate->id === $specialDate->id;
        });

        Queue::assertPushed(SendReminder::class, 1);
    }
}
