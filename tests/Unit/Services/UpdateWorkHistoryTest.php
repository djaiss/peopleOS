<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use App\Services\UpdateWorkHistory;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateWorkHistoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_work_history_entry(): void
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

        $workHistory = (new UpdateWorkHistory(
            user: $user,
            workHistory: $workHistory,
            companyName: 'Central Perk',
            jobTitle: 'Waitress',
            estimatedSalary: '10000',
            duration: '1 year',
            active: true,
        ))->execute();

        $this->assertDatabaseHas('work_information', [
            'id' => $workHistory->id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals('Central Perk', $workHistory->company_name);
        $this->assertEquals('Waitress', $workHistory->job_title);
        $this->assertEquals('10000', $workHistory->estimated_salary);
        $this->assertTrue($workHistory->active);

        $this->assertInstanceOf(
            WorkHistory::class,
            $workHistory
        );

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
                return $job->action === 'work_history_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated the work history entry for Chandler Bing';
            }
        );
    }

    #[Test]
    public function it_throws_an_exception_if_the_user_and_work_history_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and work history are not in the same account');

        (new UpdateWorkHistory(
            user: $user,
            workHistory: $workHistory,
            companyName: 'Central Perk',
            jobTitle: 'Waitress',
            estimatedSalary: '10000',
            duration: '1 year',
            active: true,
        ))->execute();
    }
}
