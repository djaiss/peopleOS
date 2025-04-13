<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\MagicLinkCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMagicLinkToLogin implements ShouldQueue
{
    use Queueable;

    private bool $valid = true;

    public function __construct(
        public string $email,
        public string $url
    ) {}

    /**
     * Send a magic link to a user so he can login to the application.
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
        try {
            User::where('email', $this->email)->firstOrFail();
        } catch (ModelNotFoundException) {
            $this->valid = false;
        }
    }

    private function send(): void
    {
        $message = (new MagicLinkCreated(
            link: $this->url,
        ))->onQueue('high');

        Mail::to($this->email)
            ->queue($message);
    }
}
