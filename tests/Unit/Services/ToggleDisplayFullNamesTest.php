<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\ToggleDisplayFullNames;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ToggleDisplayFullNamesTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_toggles_display_full_names(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'does_display_full_names' => false,
        ]);

        $user = (new ToggleDisplayFullNames(
            user: $user,
        ))->execute();

        $this->assertTrue($user->does_display_full_names);

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
                return $job->action === 'display_full_names_toggle'
                    && $job->user->id === $user->id
                    && $job->description === 'Toggled display of full names';
            }
        );
    }
}
