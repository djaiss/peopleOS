<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\UserWaitlistStatus;
use App\Jobs\SendUserWaitlistApprovedEmail;
use App\Models\User;
use App\Models\UserWaitlist;
use App\Services\ApproveUserWaitlist;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ApproveUserWaitlistTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_approves_a_waitlist_entry_as_instance_administrator(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $waitlist = UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
            'email' => 'chandler.bing@friends.com',
        ]);

        $updatedWaitlist = (new ApproveUserWaitlist(
            user: $user,
            waitlist: $waitlist,
        ))->execute();

        $this->assertDatabaseHas('user_waitlist', [
            'id' => $waitlist->id,
            'status' => UserWaitlistStatus::APPROVED->value,
        ]);

        $this->assertEquals(
            UserWaitlistStatus::APPROVED->value,
            $updatedWaitlist->status,
        );

        Queue::assertPushedOn(
            queue: 'high',
            job: SendUserWaitlistApprovedEmail::class,
            callback: function (SendUserWaitlistApprovedEmail $job): bool {
                return $job->email === 'chandler.bing@friends.com';
            },
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
            'first_name' => 'Chandler',
        ]);
        $waitlist = UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'User must be an instance administrator to approve a waitlist entry.',
        );

        (new ApproveUserWaitlist(
            user: $user,
            waitlist: $waitlist,
        ))->execute();

        $this->assertDatabaseHas('user_waitlist', [
            'id' => $waitlist->id,
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
        ]);
    }
}
