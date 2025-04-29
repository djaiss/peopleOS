<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MarketingTestimonialRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $reason,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your testimonial has been rejected',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.account.marketing-testimonial-rejected',
            text: 'mail.account.marketing-testimonial-rejected-text',
            with: [
                'reason' => $this->reason,
            ],
        );
    }
}
