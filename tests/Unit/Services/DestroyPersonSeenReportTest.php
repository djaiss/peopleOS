<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\PersonSeenReport;
use App\Models\User;
use App\Services\DestroyPersonSeenReport;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyPersonSeenReportTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_person_seen_report(): void
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

        (new DestroyPersonSeenReport(
            user: $user,
            personSeenReport: $personSeenReport,
        ))->execute();

        $this->assertDatabaseMissing('person_seen_reports', [
            'id' => $personSeenReport->id,
        ]);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'person_seen_report_deletion'
                && $job->user->id === $user->id
                && $job->description === 'Deleted having seen Ross Geller';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $personSeenReport = PersonSeenReport::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyPersonSeenReport(
            user: $user,
            personSeenReport: $personSeenReport,
        ))->execute();
    }
}
