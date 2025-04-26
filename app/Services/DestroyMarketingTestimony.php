<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimony;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyMarketingTestimony
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingTestimony $testimony,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->testimony->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function destroy(): void
    {
        $this->testimony->delete();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'marketing_testimony_deletion',
            description: 'Deleted a marketing testimony',
        )->onQueue('low');
    }
}
