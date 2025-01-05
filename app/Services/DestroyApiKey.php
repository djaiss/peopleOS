<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;

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
        $this->user->tokens()->where('id', $this->tokenId)->delete();

        $this->updateUserLastActivityDate();
        $this->log();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'api_key_deletion',
            description: 'Deleted an API key',
        );
    }
}
