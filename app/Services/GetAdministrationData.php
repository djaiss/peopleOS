<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\EmailSent;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Get all the data for the administration index page
 */
class GetAdministrationData
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function execute(): array
    {
        $logs = $this->getLogs();
        $emailsSent = $this->getEmailsSent();

        $has_more_logs = Log::where('user_id', $this->user->id)->count() > 5;
        $has_more_emails_sent = EmailSent::where('account_id', $this->user->account_id)->count() > 5;

        return [
            'logs' => $logs,
            'emails_sent' => $emailsSent,
            'has_more_logs' => $has_more_logs,
            'has_more_emails_sent' => $has_more_emails_sent,
        ];
    }

    private function getLogs(): Collection
    {
        return Log::where('user_id', $this->user->id)
            ->with('user')
            ->take(5)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Log $log): array => [
                'user' => [
                    'name' => $log->name,
                ],
                'action' => $log->action,
                'description' => $log->description,
                'created_at' => $log->created_at->diffForHumans(),
            ]);
    }

    private function getEmailsSent(): Collection
    {
        return EmailSent::where('account_id', $this->user->account_id)
            ->with('person')
            ->take(5)
            ->orderBy('sent_at', 'desc')
            ->get()
            ->map(fn (EmailSent $emailSent): array => [
                'email_type' => $emailSent->email_type,
                'email_address' => $emailSent->email_address,
                'subject' => $emailSent->subject,
                'body' => $emailSent->body,
                'sent_at' => $emailSent->sent_at?->diffForHumans(),
                'delivered_at' => $emailSent->delivered_at?->diffForHumans(),
                'bounced_at' => $emailSent->bounced_at?->diffForHumans(),
                'person' => $emailSent->person?->name,
            ]);
    }
}
