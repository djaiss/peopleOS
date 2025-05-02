<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\WaitlistWelcome;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWaitlistWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly string $email,
    ) {}

    public function handle(): void
    {
        $message = (new WaitlistWelcome($this->email))->onQueue('high');

        Mail::to($this->email)
            ->queue($message);
    }
}
