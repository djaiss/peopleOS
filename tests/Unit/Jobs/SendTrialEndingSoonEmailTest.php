<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Enums\EmailType;
use App\Jobs\SendTrialEndingSoonEmail;
use App\Mail\TrialEndingSoon;
use App\Models\EmailSent;
use App\Models\User;
use App\Services\CreateEmailSent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendTrialEndingSoonEmailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_sends_email_and_records_sent_for_valid_user(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        SendTrialEndingSoonEmail::dispatch($user->email);

        Mail::assertQueued(TrialEndingSoon::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $emailSent = EmailSent::latest()->first();
        $this->assertEquals(EmailType::TRIAL_ENDING_SOON->value, $emailSent->email_type);
        $this->assertEquals($user->email, $emailSent->email_address);
        $this->assertEquals('Your PeopleOS trial is ending soon', $emailSent->subject);
    }

    #[Test]
    public function it_does_nothing_for_invalid_user(): void
    {
        Mail::fake();

        SendTrialEndingSoonEmail::dispatch('nonexistent@example.com');

        Mail::assertNothingQueued();

        $this->assertDatabaseMissing('emails_sent', [
            'email_address' => 'nonexistent@example.com',
        ]);
    }
}
