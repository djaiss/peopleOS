<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserWaitlistStatus;
use App\Models\User;
use App\Models\UserWaitlist;
use Exception;

class RejectUserFromWaitlist
{
    public function __construct(
        private readonly User $user,
        private readonly UserWaitlist $waitlist,
    ) {}

    public function execute(): UserWaitlist
    {
        $this->validate();
        $this->updateStatus();

        return $this->waitlist;
    }

    private function validate(): void
    {
        if (! $this->user->is_instance_admin) {
            throw new Exception('User must be an instance administrator to reject a waitlist entry.');
        }
    }

    private function updateStatus(): void
    {
        $this->waitlist->update([
            'status' => UserWaitlistStatus::REJECTED->value,
        ]);
    }
}
