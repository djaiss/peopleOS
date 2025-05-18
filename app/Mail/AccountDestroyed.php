<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountDestroyed extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $reason,
        public string $activeSince,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account deleted',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.account.destroyed',
            text: 'mail.account.destroyed-text',
            with: [
                'reason' => $this->reason,
                'activeSince' => $this->activeSince,
            ],
        );
    }
}
