<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use App\Services\DestroyWorkHistory;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyWorkHistoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_work_history_entry(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        (new DestroyWorkHistory(
            user: $user,
            workHistory: $workHistory,
        ))->execute();

        $this->assertDatabaseMissing('work_information', [
            'id' => $workHistory->id,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'work_history_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted a work history entry for Chandler Bing';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and work history are not in the same account');

        (new DestroyWorkHistory(
            user: $user,
            workHistory: $workHistory,
        ))->execute();
    }
}
