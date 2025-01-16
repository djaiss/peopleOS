<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MaritalStatus;
use App\Models\User;
use App\Services\DestroyMaritalStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyMaritalStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_marital_status(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Married',
        ]);

        (new DestroyMaritalStatus(
            user: $user,
            maritalStatus: $maritalStatus,
        ))->execute();

        $this->assertDatabaseMissing('marital_statuses', [
            'id' => $maritalStatus->id,
        ]);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'marital_status_deletion'
                && $job->user->id === $user->id
                && $job->description === 'Deleted the marital status called Married';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyMaritalStatus(
            user: $user,
            maritalStatus: $maritalStatus,
        ))->execute();
    }
}
