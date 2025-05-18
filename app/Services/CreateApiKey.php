<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\SendAPICreatedEmail;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;

class CreateApiKey
{
    public function __construct(
        public User $user,
        public string $label,
    ) {}

    public function execute(): string
    {
        $token = $this->user->createToken($this->label)->plainTextToken;
        $this->updateUserLastActivityDate();
        $this->log();
        $this->sendEmail();

        return $token;
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'api_key_creation',
            description: 'Created an API key',
        )->onQueue('low');
    }

    private function sendEmail(): void
    {
        SendAPICreatedEmail::dispatch(
            email: $this->user->email,
            label: $this->label,
        )->onQueue('high');
    }
}
