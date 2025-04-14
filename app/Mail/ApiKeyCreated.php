<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApiKeyCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $label,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New API key added',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.api.created',
            text: 'mail.api.created-text',
            with: [
                'label' => $this->label,
            ],
        );
    }
}
