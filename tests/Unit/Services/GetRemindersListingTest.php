<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use App\Services\GetRemindersListing;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetRemindersListingTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_data_for_the_reminders_listing_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'name' => 'Birthday',
            'month' => 10,
            'day' => 18,
            'year' => 1967,
            'should_be_reminded' => true,
        ]);
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Work',
            'color' => 'blue',
        ]);
        $task = Task::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'is_completed' => false,
            'name' => 'Call mom',
            'task_category_id' => $taskCategory->id,
            'due_at' => '2024-03-15',
        ]);

        $array = (new GetRemindersListing(
            user: $user,
            person: $person,
        ))->execute();

        $this->assertArrayHasKeys($array, [
            'person',
            'persons',
            'active_tasks',
            'completed_tasks',
            'months',
            'total_reminders',
        ]);

        $months = $array['months'];
        $this->assertCount(1, $months);
        $this->assertEquals([
            'number' => 10,
            'name' => 'October',
            'color' => 'cyan',
            'reminders' => [
                [
                    'id' => $specialDate->id,
                    'day' => 18,
                    'date' => $specialDate->date,
                    'name' => 'Birthday',
                    'age' => $specialDate->age,
                ],
            ],
        ], $months[0]);

        $this->assertCount(0, $array['completed_tasks']);
        $this->assertCount(1, $array['active_tasks']);
        $this->assertEquals([
            'id' => $task->id,
            'name' => 'Call mom',
            'due_at' => '2024-03-15',
            'is_completed' => false,
            'task_category' => [
                'id' => $taskCategory->id,
                'name' => 'Work',
                'color' => 'blue',
            ],
        ], $array['active_tasks'][0]);

        $this->assertEquals(1, $array['total_reminders']);
    }
}
