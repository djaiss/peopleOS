<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\MagicLinkCreated;
use Illuminate\Support\Facades\Mail;

class SendMagicLink
{
    public function __construct(
        public string $email,
        public string $url,
    ) {}

    /**
     * Send a magic link to a user so he can login to the application.
     */
    public function execute(): void
    {
        $this->send();
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
