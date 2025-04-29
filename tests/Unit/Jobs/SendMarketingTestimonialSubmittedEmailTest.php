<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Enums\EmailType;
use App\Jobs\SendMarketingTestimonialSubmittedEmail;
use App\Mail\ApiKeyCreated;
use App\Mail\MarketingTestimonialSubmitted;
use App\Models\EmailSent;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendMarketingTestimonialSubmittedEmailTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_an_email_to_the_user_if_he_has_submitted_a_marketing_testimonial(): void
    {
        Mail::fake();

        User::factory()->create([
            'email' => 'ross.geller@friends.com',
        ]);

        SendMarketingTestimonialSubmittedEmail::dispatch(
            email: 'ross.geller@friends.com',
        );

        Mail::assertQueued(MarketingTestimonialSubmitted::class, function (MarketingTestimonialSubmitted $mail): bool {
            return $mail->hasTo('ross.geller@friends.com') &&
                $mail->queue === 'high';
        });

        $emailSent = EmailSent::latest()->first();

        $this->assertEquals(EmailType::MARKETING_TESTIMONIAL_SUBMITTED_EMAIL->value, $emailSent->email_type);
        $this->assertEquals('ross.geller@friends.com', $emailSent->email_address);
        $this->assertEquals('Thanks for submitting your testimonial', $emailSent->subject);
    }

    #[Test]
    public function it_does_not_send_an_email_if_the_user_does_not_exist(): void
    {
        Mail::fake();

        SendMarketingTestimonialSubmittedEmail::dispatch(
            email: 'ross.geller@friends.com',
        );

        Mail::assertNotQueued(ApiKeyCreated::class);
    }
}
