<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\EmailSent;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

/**
 * Create an email sent record.
 * Emails sent are logged and shown to the user in his settings panel.
 */
class CreateEmailSent
{
    private EmailSent $emailSent;

    public function __construct(
        public User $user,
        public string $emailType,
        public string $emailAddress,
        public string $subject,
        public string $body,
        public ?Person $person = null,
    ) {}

    public function execute(): EmailSent
    {
        $this->validate();
        $this->create();

        return $this->emailSent;
    }

    private function validate(): void
    {
        if ($this->person && $this->person->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function create(): void
    {
        $this->emailSent = EmailSent::create([
            'account_id' => $this->user->account_id,
            'person_id' => $this->person?->id,
            'uuid' => (string) Str::uuid(),
            'email_type' => $this->emailType,
            'email_address' => $this->emailAddress,
            'subject' => $this->subject,
            'body' => $this->body,
            'sent_at' => now(),
        ]);
    }
}
