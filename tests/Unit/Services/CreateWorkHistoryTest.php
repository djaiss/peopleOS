<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use App\Services\CreateWorkHistory;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateWorkHistoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_work_history(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $workHistory = (new CreateWorkHistory(
            user: $user,
            person: $person,
            companyName: 'Central Perk',
            jobTitle: 'Waitress',
            duration: '1 year',
            estimatedSalary: '10000',
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
                return $job->action === 'work_history_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created a work history entry for Chandler Bing';
            }
        );
    }

    #[Test]
    public function it_throws_an_exception_if_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and person are not in the same account');

        (new CreateWorkHistory(
            user: $user,
            person: $person,
            companyName: 'Central Perk',
            jobTitle: 'Waitress',
            duration: '1 year',
            estimatedSalary: '10000',
            active: true,
        ))->execute();
    }
}
