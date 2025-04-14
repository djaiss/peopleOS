<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\ApiKeyDestroyed;
use App\Mail\LoginFailed;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendAPIDesrtroyedEmail implements ShouldQueue
{
    use Queueable;

    private bool $valid = true;

    public function __construct(
        public string $email,
        public string $label,
    ) {}

    /**
     * Send an email to the user when an API key is created.
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
        $message = (new ApiKeyDestroyed($this->label))->onQueue('high');

        Mail::to($this->email)
            ->queue($message);
    }
}
