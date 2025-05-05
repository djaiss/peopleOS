<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\EmailType;
use App\Mail\MarketingTestimonialReviewed;
use App\Models\User;
use App\Services\CreateEmailSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMarketingTestimonialReviewedEmail implements ShouldQueue
{
    use Queueable;

    private bool $valid = true;

    private User $user;

    public function __construct(
        public string $email,
    ) {}

    /**
     * Send an email to the user when a marketing testimonial has been reviewed.
     */
    public function handle(): void
    {
        $this->validate();

        if ($this->valid) {
            $this->send();
            $this->recordEmailSent();
        }
    }

    private function validate(): void
    {
        try {
            $this->user = User::where('email', $this->email)->firstOrFail();
        } catch (ModelNotFoundException) {
            $this->valid = false;
        }
    }

    private function send(): void
    {
        $message = (new MarketingTestimonialReviewed())->onQueue('high');

        Mail::to($this->email)
            ->queue($message);
    }

    private function recordEmailSent(): void
    {
        (new CreateEmailSent(
            user: $this->user,
            emailType: EmailType::MARKETING_TESTIMONIAL_REVIEWED_EMAIL->value,
            emailAddress: $this->user->email,
            subject: 'Your testimonial has been reviewed',
            body: (new MarketingTestimonialReviewed())->render(),
            person: null,
        ))->execute();
    }
}
