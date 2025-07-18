<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\Update2faMethod;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class Update2faMethodTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_user_2fa_method(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'two_factor_preferred_method' => 'email',
        ]);

        $updatedUser = (new Update2faMethod(
            user: $user,
            preferredMethods: 'sms',
        ))->execute();

        $this->assertEquals(
            'sms',
            $updatedUser->two_factor_preferred_method,
        );

        $this->assertEquals(
            'sms',
            $user->fresh()->two_factor_preferred_method,
        );

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
                return $job->user->id === $user->id
                    && $job->action === 'update_preferred_method'
                    && $job->description === 'Updated their preferred 2FA method';
            },
        );
    }
}
