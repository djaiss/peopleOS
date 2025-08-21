<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\Task;
use App\Models\TaskCategory;
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

    #[Test]
    public function it_should_return_incomplete_tasks(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-06-13 10:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $category = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Email',
            'color' => 'bg-green-100',
        ]);

        // Incomplete task with category and due date
        $task1 = Task::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'task_category_id' => $category->id,
            'name' => 'Send follow-up',
            'is_completed' => false,
            'due_at' => Carbon::parse('2025-06-11'),
        ]);
        // Incomplete task without category
        $task2 = Task::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'task_category_id' => null,
            'name' => 'Call back',
            'is_completed' => false,
            'due_at' => Carbon::parse('2025-06-12'),
        ]);
        // Completed task (should not be returned)
        Task::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'task_category_id' => $category->id,
            'name' => 'Already done',
            'is_completed' => true,
            'due_at' => Carbon::parse('2025-06-10'),
        ]);

        $service = new GetDashboardInformation(user: $user);
        $tasks = $service->getTasks();

        $this->assertCount(2, $tasks);

        $this->assertEquals([
            0 => [
                'id' => $task1->id,
                'name' => 'Send follow-up',
                'task_category' => [
                    'id' => $category->id,
                    'name' => 'Email',
                    'color' => 'bg-green-100',
                ],
                'due_at' => '2025-06-11',
                'person' => [
                    'id' => $person->id,
                    'name' => 'Rachel Green',
                    'slug' => $person->slug,
                    'avatar' => [
                        '40' => $person->getAvatar(40),
                        '80' => $person->getAvatar(80),
                    ],
                ],
            ],
            1 => [
                'id' => $task2->id,
                'name' => 'Call back',
                'task_category' => [
                    'id' => null,
                    'name' => null,
                    'color' => null,
                ],
                'due_at' => '2025-06-12',
                'person' => [
                    'id' => $person->id,
                    'name' => 'Rachel Green',
                    'slug' => $person->slug,
                    'avatar' => [
                        '40' => $person->getAvatar(40),
                        '80' => $person->getAvatar(80),
                    ],
                ],
            ],
        ], $tasks->toArray());
    }
}
