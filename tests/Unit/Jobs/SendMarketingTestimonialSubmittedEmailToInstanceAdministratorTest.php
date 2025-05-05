<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\SendMarketingTestimonialSubmittedEmailToInstanceAdministrator;
use App\Mail\MarketingTestimonialReadyToReview;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendMarketingTestimonialSubmittedEmailToInstanceAdministratorTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_an_email_to_the_instance_administrator_when_a_testimonial_is_submitted(): void
    {
        Mail::fake();

        Config::set('peopleos.marketing_testimonial_notification_email', 'monica.geller@friends.com');

        SendMarketingTestimonialSubmittedEmailToInstanceAdministrator::dispatch();

        Mail::assertQueued(MarketingTestimonialReadyToReview::class, function (MarketingTestimonialReadyToReview $mail): bool {
            return $mail->hasTo('monica.geller@friends.com') &&
                $mail->queue === 'high';
        });
    }
}
