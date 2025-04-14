<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLinkCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $link,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Login to PeopleOS',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.auth.magic-link-created',
            text: 'mail.auth.magic-link-created-text',
            with: [
                'link' => $this->link,
            ],
        );
    }
}
