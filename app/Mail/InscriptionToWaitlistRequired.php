<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscriptionToWaitlistRequired extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $link,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm your inscription to the PeopleOS waitlist',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.account.inscription-to-waitlist-required',
            text: 'mail.account.inscription-to-waitlist-required-text',
            with: [
                'link' => $this->link,
            ],
        );
    }
}
