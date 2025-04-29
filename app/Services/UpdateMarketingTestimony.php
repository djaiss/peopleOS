<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MarketingTestimonyStatus;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimony;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateMarketingTestimony
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingTestimony $testimonyObject,
        private readonly ?string $nameToDisplay = null,
        private readonly ?string $testimony = null,
        private readonly ?string $urlToPointTo = null,
        private readonly ?bool $displayAvatar = null,
    ) {}

    public function execute(): MarketingTestimony
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->testimonyObject;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->testimonyObject->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->testimonyObject->update([
            'status' => MarketingTestimonyStatus::PENDING->value,
            'name_to_display' => $this->nameToDisplay ?? $this->testimonyObject->name_to_display,
            'testimony' => $this->testimony ?? $this->testimonyObject->testimony,
            'url_to_point_to' => $this->urlToPointTo ?? $this->testimonyObject->url_to_point_to,
            'display_avatar' => $this->displayAvatar ?? $this->testimonyObject->display_avatar,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'marketing_testimony_update',
            description: 'Updated a marketing testimony',
        )->onQueue('low');
    }
}
