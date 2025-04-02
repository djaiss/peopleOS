<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Mail\ApiKeyDestroyed;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class DestroyApiKey
{
    public function __construct(
        public User $user,
        public int $tokenId,
    ) {}

    /**
     * Destroy an API key.
     */
    public function execute(): void
    {
        $token = $this->user->tokens()->where('id', $this->tokenId)->first();
        $label = $token->name;
        $token->delete();

        $this->updateUserLastActivityDate();
        $this->log();
        $this->sendMail($label);
        $this->incrementEmailSent();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'api_key_deletion',
            description: 'Deleted an API key',
        )->onQueue('low');
    }

    private function sendMail(string $label): void
    {
        Mail::to($this->user->email)
            ->queue(new ApiKeyDestroyed($label));
    }

    private function incrementEmailSent(): void
    {
        $this->user->account->increment('emails_sent');
    }
}
