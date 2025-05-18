<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserWaitlistStatus;
use App\Jobs\SendUserWaitlistApprovedEmail;
use App\Models\User;
use App\Models\UserWaitlist;
use Exception;

/**
 * Approve a user waitlist entry. The user must be an instance administrator.
 */
class ApproveUserWaitlist
{
    public function __construct(
        private readonly User $user,
        private readonly UserWaitlist $waitlist,
    ) {}

    public function execute(): UserWaitlist
    {
        $this->validate();
        $this->updateStatus();
        $this->send();

        return $this->waitlist;
    }

    private function validate(): void
    {
        if (! $this->user->is_instance_admin) {
            throw new Exception(
                'User must be an instance administrator to approve a waitlist entry.',
            );
        }
    }

    private function updateStatus(): void
    {
        $this->waitlist->update([
            'status' => UserWaitlistStatus::APPROVED->value,
        ]);
    }

    private function send(): void
    {
        SendUserWaitlistApprovedEmail::dispatch(
            $this->waitlist->email,
        )->onQueue('high');
    }
}
