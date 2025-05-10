<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserWaitlistStatus;
use App\Jobs\AskUserToConfirmInscriptionToWaitlist;
use App\Models\UserWaitlist;
use Exception;
use Illuminate\Support\Str;

class AddEmailToWaitlist
{
    private UserWaitlist $waitlistEntry;

    public function __construct(
        private readonly string $email,
    ) {}

    public function execute(): UserWaitlist
    {
        $this->validate();
        $this->create();
        $this->sendWelcomeEmail();

        return $this->waitlistEntry;
    }

    private function validate(): void
    {
        $waitlistEntries = UserWaitlist::select('email')->get();
        foreach ($waitlistEntries as $entry) {
            if ($entry->email === $this->email) {
                throw new Exception('User already in waitlist');
            }
        }
    }

    private function create(): void
    {
        $this->waitlistEntry = UserWaitlist::create([
            'email' => $this->email,
            'confirmation_code' => Str::uuid(),
            'status' => UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value,
        ]);
    }

    private function sendWelcomeEmail(): void
    {
        $link = (new CreateWaitlistConfirmationLink(
            code: $this->waitlistEntry->confirmation_code,
        ))->execute();

        AskUserToConfirmInscriptionToWaitlist::dispatch(
            email: $this->email,
            link: $link,
        )->onQueue('low');
    }
}
