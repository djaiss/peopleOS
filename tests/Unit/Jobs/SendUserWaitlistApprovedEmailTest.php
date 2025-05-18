<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\SendUserWaitlistApprovedEmail;
use App\Mail\UserWaitlistApproved;
use App\Models\UserWaitlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendUserWaitlistApprovedEmailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_sends_email_to_user_in_waitlist(): void
    {
        Mail::fake();
        UserWaitlist::factory()->create([
            'email' => 'test@example.com',
        ]);

        SendUserWaitlistApprovedEmail::dispatch(
            'test@example.com',
        );

        Mail::assertQueued(UserWaitlistApproved::class, function (UserWaitlistApproved $mail) {
            return $mail->hasTo('test@example.com') &&
                $mail->queue === 'high';
        });
    }

    #[Test]
    public function it_does_not_send_email_if_user_not_in_waitlist(): void
    {
        Mail::fake();

        SendUserWaitlistApprovedEmail::dispatch(
            'nonexistent@example.com',
        );

        Mail::assertNothingQueued();
    }
}
