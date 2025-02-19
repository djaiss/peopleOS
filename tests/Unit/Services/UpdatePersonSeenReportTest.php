<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\PersonSeenReport;
use App\Models\User;
use App\Services\UpdatePersonSeenReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePersonSeenReportTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_person_seen_report(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $personSeenReport = PersonSeenReport::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $newSeenAt = Carbon::create(2024, 1, 1, 12, 0, 0);
        $newPeriodOfTime = 'At Central Perk';

        $updatedReport = (new UpdatePersonSeenReport(
            user: $user,
            personSeenReport: $personSeenReport,
            seenAt: $newSeenAt,
            periodOfTime: $newPeriodOfTime,
        ))->execute();

        $this->assertDatabaseHas('person_seen_reports', [
            'id' => $personSeenReport->id,
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals($newSeenAt, $updatedReport->seen_at);
        $this->assertEquals($newPeriodOfTime, $updatedReport->period_of_time);

        $this->assertInstanceOf(
            PersonSeenReport::class,
            $updatedReport
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'person_seen_report_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated having seen Ross Geller';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $personSeenReport = PersonSeenReport::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdatePersonSeenReport(
            user: $user,
            personSeenReport: $personSeenReport,
            seenAt: now(),
            periodOfTime: 'At Central Perk',
        ))->execute();
    }
}
