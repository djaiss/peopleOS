<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\ToggleBirthdate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ToggleBirthdateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_toggles_display_age(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'does_display_age' => false,
        ]);

        $user = (new ToggleBirthdate(
            user: $user,
        ))->execute();

        $this->assertTrue($user->does_display_age);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'display_age_toggle'
                && $job->user->id === $user->id
                && $job->description === 'Toggled display of age';
        });
    }
}
