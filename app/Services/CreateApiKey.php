<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Mail\ApiKeyCreated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CreateApiKey
{
    public function __construct(
        public User $user,
        public string $label,
    ) {}

    /**
     * Create an API key for the user.
     */
    public function execute(): string
    {
        $token = $this->user->createToken($this->label)->plainTextToken;
        $this->updateUserLastActivityDate();
        $this->log();
        $this->sendMail();
        $this->incrementEmailsSent();

        return $token;
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'api_key_creation',
            description: 'Created an API key',
        );
    }

    private function sendMail(): void
    {
        Mail::to($this->user->email)
            ->queue(new ApiKeyCreated($this->label));
    }

    private function incrementEmailsSent(): void
    {
        $this->user->account->increment('emails_sent');
    }
}
