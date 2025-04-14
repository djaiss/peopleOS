<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\SendAPIDesrtroyedEmail;
use App\Jobs\UpdateUserLastActivityDate;
use App\Mail\ApiKeyDestroyed;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class DestroyApiKey
{
    private string $label;

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
        $this->label = $token->name;
        $token->delete();

        $this->updateUserLastActivityDate();
        $this->log();
        $this->sendEmail();
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

    private function sendEmail(): void
    {
        SendAPIDesrtroyedEmail::dispatch(
            email: $this->user->email,
            label: $this->label,
        )->onQueue('high');
    }
}
