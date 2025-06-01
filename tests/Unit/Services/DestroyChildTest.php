<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Child;
use App\Models\User;
use App\Services\DestroyChild;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_child(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $child = Child::factory()->create([
            'account_id' => $user->account_id,
        ]);

        (new DestroyChild(
            user: $user,
            child: $child,
        ))->execute();

        $this->assertDatabaseMissing('children', [
            'id' => $child->id,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'child_relationship_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted a child';
            },
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $child = Child::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyChild(
            user: $user,
            child: $child,
        ))->execute();
    }
}
