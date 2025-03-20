<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\TaskCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskCategoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($taskCategory->account()->exists());
    }
}
