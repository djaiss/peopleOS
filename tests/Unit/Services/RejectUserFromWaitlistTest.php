<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\UserWaitlistStatus;
use App\Models\User;
use App\Models\UserWaitlist;
use App\Services\RejectUserFromWaitlist;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RejectUserFromWaitlistTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_rejects_a_waitlist_entry_as_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $waitlist = UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
        ]);

        $updatedWaitlist = (new RejectUserFromWaitlist(
            user: $user,
            waitlist: $waitlist,
        ))->execute();

        $this->assertDatabaseHas('user_waitlist', [
            'id' => $waitlist->id,
            'status' => UserWaitlistStatus::REJECTED->value,
        ]);

        $this->assertEquals(
            UserWaitlistStatus::REJECTED->value,
            $updatedWaitlist->status
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
            'first_name' => 'Ross',
        ]);
        $waitlist = UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User must be an instance administrator to reject a waitlist entry.');

        (new RejectUserFromWaitlist(
            user: $user,
            waitlist: $waitlist,
        ))->execute();

        $this->assertDatabaseHas('user_waitlist', [
            'id' => $waitlist->id,
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
        ]);
    }
}
