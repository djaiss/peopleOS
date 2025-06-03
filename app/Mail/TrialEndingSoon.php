<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrialEndingSoon extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $link,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your PeopleOS trial is ending soon',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.account.trial-ending-soon',
            text: 'mail.account.trial-ending-soon-text',
            with: [
                'link' => $this->link,
            ],
        );
    }
}
