<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserInvited extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $temporarySignedRoute,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You are invited to join the account',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.user.invited',
            text: 'mail.user.invited-text',
            with: [
                'temporarySignedRoute' => $this->temporarySignedRoute,
            ],
        );
    }
}
