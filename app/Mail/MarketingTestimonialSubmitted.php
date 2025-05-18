<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MarketingTestimonialSubmitted extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct() {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thanks for submitting your testimonial',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.account.marketing-testimonial-submitted',
            text: 'mail.account.marketing-testimonial-submitted-text',
        );
    }
}
