<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApiKeyDestroyed extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $label,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Api key removed',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.api.destroyed',
            text: 'mail.api.destroyed-text',
            with: [
                'label' => $this->label,
            ],
        );
    }
}
