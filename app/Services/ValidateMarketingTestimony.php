<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MarketingTestimonyStatus;
use App\Models\MarketingTestimony;
use App\Models\User;
use Exception;

class ValidateMarketingTestimony
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingTestimony $testimony,
    ) {}

    public function execute(): MarketingTestimony
    {
        $this->validate();
        $this->updateStatus();

        return $this->testimony;
    }

    private function validate(): void
    {
        if (! $this->user->is_instance_admin) {
            throw new Exception('User must be an instance administrator to validate a testimony.');
        }
    }

    private function updateStatus(): void
    {
        $this->testimony->update([
            'status' => MarketingTestimonyStatus::APPROVED->value,
        ]);
    }
}
