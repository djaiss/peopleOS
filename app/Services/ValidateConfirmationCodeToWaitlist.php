<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserWaitlistStatus;
use App\Models\UserWaitlist;
use Exception;

/**
 * Validate the given confirmation code to suscribe the user to the waitlist.
 */
class ValidateConfirmationCodeToWaitlist
{
    private ?UserWaitlist $waitlistEntry = null;

    public function __construct(
        private readonly string $code,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->update();
    }

    private function validate(): void
    {
        $waitlistEntries = UserWaitlist::select('id', 'confirmation_code', 'confirmed_at')->get();

        // we need to iterate over hydrated models as the confirmation_code
        // is encrypted and cannot be compared to a raw string
        foreach ($waitlistEntries as $entry) {
            if ($entry->confirmation_code === $this->code) {
                $this->waitlistEntry = $entry;
            }
        }

        if (! $this->waitlistEntry instanceof UserWaitlist) {
            throw new Exception('Invalid confirmation code');
        }

        if ($this->waitlistEntry->confirmed_at) {
            throw new Exception('User already confirmed');
        }
    }

    private function update(): void
    {
        $this->waitlistEntry->update([
            'confirmed_at' => now(),
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
        ]);
    }
}
