<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UpdateUserInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateUserInformationTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_user_information(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'email' => 'michael@dundermifflin.com',
        ]);

        $this->executeService($user);
    }

    #[Test]
    public function it_triggers_email_verification_when_email_changes(): void
    {
        Event::fake();

        $user = User::factory()->create([
            'email' => 'michael@dundermifflin.com',
            'email_verified_at' => now(),
        ]);

        $this->executeService($user, 'dwight@dundermifflin.com');

        Event::assertDispatched(Registered::class);
        $this->assertNull($user->refresh()->email_verified_at);
    }

    #[Test]
    public function it_does_not_trigger_email_verification_when_email_stays_same(): void
    {
        Event::fake();

        $user = User::factory()->create([
            'email' => 'michael@dundermifflin.com',
            'email_verified_at' => now(),
        ]);

        $this->executeService($user, 'michael@dundermifflin.com');

        Event::assertNotDispatched(Registered::class);
        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    private function executeService(User $user, string $email = 'dwight@dundermifflin.com'): void
    {
        $updatedUser = (new UpdateUserInformation(
            user: $user,
            email: $email,
            firstName: 'Dwight',
            lastName: 'Schrute',
        ))->execute();

        $this->assertDatabaseHas('users', [
            'id' => $updatedUser->id,
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
            'email' => $email,
        ]);

        $this->assertInstanceOf(
            User::class,
            $updatedUser
        );
    }
}
