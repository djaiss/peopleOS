<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Enums\EmailType;
use App\Jobs\SendMarketingTestimonialReviewedEmail;
use App\Mail\ApiKeyCreated;
use App\Mail\MarketingTestimonialReviewed;
use App\Models\EmailSent;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendMarketingTestimonialReviewedEmailTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_an_email_to_the_user_if_his_testimonial_has_been_reviewed(): void
    {
        Mail::fake();

        User::factory()->create([
            'email' => 'ross.geller@friends.com',
        ]);

        SendMarketingTestimonialReviewedEmail::dispatch(
            email: 'ross.geller@friends.com',
        );

        Mail::assertQueued(MarketingTestimonialReviewed::class, function (MarketingTestimonialReviewed $mail): bool {
            return $mail->hasTo('ross.geller@friends.com') &&
                $mail->queue === 'high';
        });

        $emailSent = EmailSent::latest()->first();

        $this->assertEquals(EmailType::MARKETING_TESTIMONIAL_REVIEWED_EMAIL->value, $emailSent->email_type);
        $this->assertEquals('ross.geller@friends.com', $emailSent->email_address);
        $this->assertEquals('Your testimonial has been reviewed', $emailSent->subject);
    }

    #[Test]
    public function it_does_not_send_an_email_if_the_user_does_not_exist(): void
    {
        Mail::fake();

        SendMarketingTestimonialReviewedEmail::dispatch(
            email: 'ross.geller@friends.com',
        );

        Mail::assertNotQueued(ApiKeyCreated::class);
    }
}
