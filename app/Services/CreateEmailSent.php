<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\EmailSent;
use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateEmailSent
{
    private EmailSent $emailSent;

    public function __construct(
        public User $user,
        public ?Person $person = null,
        public string $emailType,
        public string $emailAddress,
        public string $subject,
        public string $body,
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
            'email_type' => $this->emailType,
            'email_address' => $this->emailAddress,
            'subject' => $this->subject,
            'body' => $this->body,
        ]);
    }
}
