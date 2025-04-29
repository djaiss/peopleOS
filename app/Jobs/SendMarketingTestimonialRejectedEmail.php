<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\EmailType;
use App\Mail\MarketingTestimonialRejected;
use App\Models\User;
use App\Services\CreateEmailSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMarketingTestimonialRejectedEmail implements ShouldQueue
{
    use Queueable;

    private bool $valid = true;

    private User $user;

    public function __construct(
        public string $email,
        public string $reason,
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
        $message = (new MarketingTestimonialRejected($this->reason))->onQueue('high');

        Mail::to($this->email)
            ->queue($message);
    }

    private function recordEmailSent(): void
    {
        (new CreateEmailSent(
            user: $this->user,
            emailType: EmailType::MARKETING_TESTIMONIAL_REJECTED_EMAIL->value,
            emailAddress: $this->user->email,
            subject: 'Your testimonial has been rejected',
            body: (new MarketingTestimonialRejected($this->reason))->render(),
            person: null,
        ))->execute();
    }
}
