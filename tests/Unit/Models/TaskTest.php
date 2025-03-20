<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Person;
use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $task = Task::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($task->account()->exists());
    }

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $task = Task::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($task->person()->exists());
    }

    #[Test]
    public function it_belongs_to_a_task_category(): void
    {
        $taskCategory = TaskCategory::factory()->create();
        $task = Task::factory()->create([
            'task_category_id' => $taskCategory->id,
        ]);

        $this->assertTrue($task->taskCategory()->exists());
    }
}
