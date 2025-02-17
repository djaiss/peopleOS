<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderSent extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $slug,
        public string $personName,
        public string $date,
        public string $age,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder for '.$this->personName,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.reminder.sent',
            text: 'mail.reminder.sent-text',
            with: [
                'name' => $this->name,
                'slug' => $this->slug,
                'personName' => $this->personName,
                'date' => $this->date,
                'age' => $this->age,
            ],
        );
    }
}
