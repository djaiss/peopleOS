<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\UpdateUserInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateUserInformationTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_user_information(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'email' => 'ross.geller@friends.com',
        ]);

        $this->executeService($user);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'personal_profile_update' && $job->user->id === $user->id;
        });
    }

    #[Test]
    public function it_triggers_email_verification_when_email_changes(): void
    {
        Event::fake();

        $user = User::factory()->create([
            'email' => 'ross.geller@friends.com',
            'email_verified_at' => now(),
        ]);

        $this->executeService($user, 'monica.geller@friends.com');

        Event::assertDispatched(Registered::class);
        $this->assertNull($user->refresh()->email_verified_at);
    }

    #[Test]
    public function it_does_not_trigger_email_verification_when_email_stays_same(): void
    {
        Event::fake();

        $user = User::factory()->create([
            'email' => 'ross.geller@friends.com',
            'email_verified_at' => now(),
        ]);

        $this->executeService($user, 'ross.geller@friends.com');

        Event::assertNotDispatched(Registered::class);
        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    #[Test]
    public function it_updates_user_birth_date(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'born_at' => null,
        ]);

        $this->executeService($user, 'ross.geller@friends.com', '03/15/1985');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'born_at' => '1985-03-15 00:00:00',
        ]);
    }

    #[Test]
    public function it_fails_if_birth_date_is_in_the_future(): void
    {
        $user = User::factory()->create();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Birth date cannot be in the future');

        $this->executeService($user, 'ross.geller@friends.com', '03/15/2025');
    }

    #[Test]
    public function it_fails_if_birth_date_format_is_invalid(): void
    {
        $user = User::factory()->create();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Birth date must be in MM/DD/YYYY format');

        $this->executeService($user, 'ross.geller@friends.com', '2025-03-15');
    }

    private function executeService(User $user, string $email = 'dwight@dundermifflin.com', ?string $bornAt = null): void
    {
        $updatedUser = (new UpdateUserInformation(
            user: $user,
            email: $email,
            firstName: 'Ross',
            lastName: 'Geller',
            nickname: 'Ross',
            bornAt: $bornAt,
        ))->execute();

        $this->assertDatabaseHas('users', [
            'id' => $updatedUser->id,
            'email' => $email,
        ]);

        $this->assertEquals('Ross', $updatedUser->first_name);
        $this->assertEquals('Geller', $updatedUser->last_name);
        $this->assertEquals('Ross', $updatedUser->nickname);

        $this->assertInstanceOf(
            User::class,
            $updatedUser
        );
    }
}
