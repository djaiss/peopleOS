<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MaritalStatus;
use App\Models\User;
use App\Services\UpdateMaritalStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateMaritalStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_marital_status(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Married',
            'position' => 1,
        ]);

        $updatedMaritalStatus = (new UpdateMaritalStatus(
            user: $user,
            maritalStatus: $maritalStatus,
            name: 'Divorced',
            position: 2,
        ))->execute();

        $this->assertDatabaseHas('marital_statuses', [
            'id' => $maritalStatus->id,
            'account_id' => $user->account_id,
            'position' => 2,
        ]);

        $this->assertEquals('Divorced', $updatedMaritalStatus->name);

        $this->assertInstanceOf(
            MaritalStatus::class,
            $updatedMaritalStatus
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'marital_status_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated the marital status called Divorced';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateMaritalStatus(
            user: $user,
            maritalStatus: $maritalStatus,
            name: 'Divorced',
            position: 2,
        ))->execute();
    }
}
