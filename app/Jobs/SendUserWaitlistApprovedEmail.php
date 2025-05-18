<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\UserWaitlistApproved;
use App\Models\User;
use App\Models\UserWaitlist;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        $found = UserWaitlist::all()->contains(fn($waitlist): bool => $waitlist->email === $this->email);

        if (! $found) {
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
