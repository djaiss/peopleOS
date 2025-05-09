<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\EmailType;
use App\Mail\MarketingTestimonialSubmitted;
use App\Mail\UserWaitlistApproved;
use App\Models\User;
use App\Models\UserWaitlist;
use App\Services\CreateEmailSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendUserWaitlistApprovedEmail implements ShouldQueue
{
    use Queueable;

    private bool $valid = true;

    public function __construct(
        public string $email,
    ) {}

    /**
     * Send an email to the user when the waitlist is approved.
     */
    public function handle(): void
    {
        $this->validate();

        if ($this->valid) {
            $this->send();
        }
    }

    private function validate(): void
    {

        // Since email is encrypted, we need to iterate over all records
        $found = UserWaitlist::all()->contains(function ($waitlist) {
            return $waitlist->email === $this->email;
        });

        if (!$found) {
            $this->valid = false;
        }
    }

    private function send(): void
    {
        $message = (new UserWaitlistApproved())->onQueue('high');

        Mail::to($this->email)
            ->queue($message);
    }
}
