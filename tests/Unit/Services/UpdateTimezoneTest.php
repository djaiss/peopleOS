<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\UpdateTimezone;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTimezoneTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_user_timezone(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'timezone' => 'UTC',
        ]);

        $updatedUser = (new UpdateTimezone(
            user: $user,
            timezone: 'America/New_York',
        ))->execute();

        $this->assertEquals('America/New_York', $updatedUser->timezone);

        $this->assertInstanceOf(
            User::class,
            $updatedUser
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'timezone_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated their timezone';
        });
    }
}
