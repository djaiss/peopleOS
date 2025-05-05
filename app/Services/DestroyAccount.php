<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\AccountDestroyed;
use App\Models\AccountDeletionReason;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class DestroyAccount
{
    public function __construct(
        private readonly User $user,
        private readonly string $reason,
    ) {}

    public function execute(): void
    {
        $this->user->account->delete();
        $this->sendMail();
        $this->logAccountDeletion();
    }

    private function sendMail(): void
    {
        Mail::to(config('peopleos.account_deletion_notification_email'))
            ->queue(new AccountDestroyed(
                reason: $this->reason,
                activeSince: $this->user->account->created_at->format('Y-m-d'),
            ));
    }

    private function logAccountDeletion(): void
    {
        AccountDeletionReason::create([
            'reason' => $this->reason,
        ]);
    }
}
