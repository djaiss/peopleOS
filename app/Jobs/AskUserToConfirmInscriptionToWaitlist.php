<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\InscriptionToWaitlistRequired;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Send a confirmation email to the user to confirm their email address.
 */
class AskUserToConfirmInscriptionToWaitlist implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly string $email,
        public readonly string $link,
    ) {}

    public function handle(): void
    {
        $message = (new InscriptionToWaitlistRequired(
            link: $this->link,
        ))->onQueue('high');

        Mail::to($this->email)
            ->queue($message);
    }
}
