<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MarketingTestimonialReviewed extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct() {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your testimonial has been reviewed',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.account.marketing-testimonial-reviewed',
            text: 'mail.account.marketing-testimonial-reviewed-text',
        );
    }
}
