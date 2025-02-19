<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\PersonSeenReport;
use App\Models\User;
use App\Services\CreatePersonSeenReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreatePersonSeenReportTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_person_seen_report(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::create(2024, 1, 1));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $seenAt = Carbon::now();
        $periodOfTime = 'morning';

        $report = (new CreatePersonSeenReport(
            user: $user,
            person: $person,
            seenAt: $seenAt,
            periodOfTime: $periodOfTime,
        ))->execute();

        $this->assertDatabaseHas('person_seen_reports', [
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'seen_at' => $seenAt,
        ]);

        $this->assertEquals($periodOfTime, 'morning');

        $this->assertInstanceOf(
            PersonSeenReport::class,
            $report
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'person_seen_report_creation'
                && $job->user->id === $user->id
                && $job->description === 'Logged having seen Ross Geller';
        });
    }

    #[Test]
    public function it_fails_if_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new CreatePersonSeenReport(
            user: $user,
            person: $person,
            seenAt: Carbon::now(),
        ))->execute();
    }
}
