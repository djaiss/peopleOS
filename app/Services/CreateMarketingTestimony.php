<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MarketingTestimonyStatus;
use App\Jobs\LogUserAction;
use App\Jobs\SendMarketingTestimonialSubmittedEmail;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimony;
use App\Models\User;

class CreateMarketingTestimony
{
    private MarketingTestimony $testimonyObject;

    public function __construct(
        private readonly User $user,
        private readonly string $nameToDisplay,
        private readonly string $testimony,
        private readonly ?string $urlToPointTo = null,
        private readonly bool $displayAvatar = false,
    ) {}

    public function execute(): MarketingTestimony
    {
        $this->create();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
        $this->sendEmail();

        return $this->testimonyObject;
    }

    private function create(): void
    {
        $this->testimonyObject = MarketingTestimony::create([
            'account_id' => $this->user->account_id,
            'user_id' => $this->user->id,
            'status' => MarketingTestimonyStatus::PENDING->value,
            'name_to_display' => $this->nameToDisplay,
            'url_to_point_to' => $this->urlToPointTo,
            'display_avatar' => $this->displayAvatar,
            'testimony' => $this->testimony,
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
            action: 'marketing_testimony_creation',
            description: 'Created a marketing testimony',
        )->onQueue('low');
    }

    private function sendEmail(): void
    {
        SendMarketingTestimonialSubmittedEmail::dispatch(
            email: $this->user->email,
        )->onQueue('high');
    }
}
