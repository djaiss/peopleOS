<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginFailed extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct() {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Login attempt on PeopleOS',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.auth.login-failed',
            text: 'mail.auth.login-failed-text',
        );
    }
}
