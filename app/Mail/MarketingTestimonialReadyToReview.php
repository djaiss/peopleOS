<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MarketingTestimonialReadyToReview extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct() {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'A new marketing testimonial is ready to be reviewed',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.account.marketing-testimonial-ready-to-review',
            text: 'mail.account.marketing-testimonial-ready-to-review-text',
            with: [
                'url' => route('instance.testimonial.index'),
            ],
        );
    }
}
