<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\MarketingTestimonialReadyToReview;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMarketingTestimonialSubmittedEmailToInstanceAdministrator implements ShouldQueue
{
    use Queueable;

    /**
     * Send an email to the instance administrator when a marketing testimonial
     * has been submitted.
     */
    public function handle(): void
    {
        $this->send();
    }

    private function send(): void
    {
        $message = (new MarketingTestimonialReadyToReview())->onQueue('high');

        Mail::to(config('peopleos.marketing_testimonial_notification_email'))
            ->queue($message);
    }
}
