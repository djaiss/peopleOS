<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateUserLastActivityDateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_user_last_activity_date(): void
    {
        // Create a user without last_activity_at
        $user = User::factory()->create([
            'last_activity_at' => null,
        ]);

        UpdateUserLastActivityDate::dispatch($user);

        $user->refresh();

        $this->assertNotNull($user->last_activity_at);
        $this->assertEqualsWithDelta(
            now(),
            $user->last_activity_at,
            1, // Delta of 1 second
        );
    }

    #[Test]
    public function it_updates_existing_last_activity_date(): void
    {
        $user = User::factory()->create([
            'last_activity_at' => now()->subDays(1),
        ]);

        $oldDate = $user->last_activity_at;

        UpdateUserLastActivityDate::dispatch($user);

        $user->refresh();

        $this->assertNotNull($user->last_activity_at);
        $this->assertNotEquals(
            $oldDate,
            $user->last_activity_at,
        );
        $this->assertEqualsWithDelta(
            now(),
            $user->last_activity_at,
            1, // Delta of 1 second
        );
    }
}
