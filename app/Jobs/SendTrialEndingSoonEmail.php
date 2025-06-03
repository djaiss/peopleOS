<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\EmailType;
use App\Mail\TrialEndingSoon;
use App\Models\User;
use App\Services\CreateEmailSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendTrialEndingSoonEmail implements ShouldQueue
{
    use Queueable;

    private bool $valid = true;

    private User $user;

    public function __construct(
        public string $email,
    ) {}

    /**
     * Send an email to the user when their trial is ending soon.
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
        $link = route('upgrade.index');
        $message = (new TrialEndingSoon($link))->onQueue('high');

        Mail::to($this->email)
            ->queue($message);
    }

    private function recordEmailSent(): void
    {
        $link = route('upgrade.index');

        (new CreateEmailSent(
            user: $this->user,
            emailType: EmailType::TRIAL_ENDING_SOON->value,
            emailAddress: $this->user->email,
            subject: 'Your PeopleOS trial is ending soon',
            body: (new TrialEndingSoon($link))->render(),
            person: null,
        ))->execute();
    }
}
