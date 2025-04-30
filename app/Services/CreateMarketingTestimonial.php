<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MarketingTestimonialStatus;
use App\Jobs\LogUserAction;
use App\Jobs\SendMarketingTestimonialSubmittedEmail;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimonial;
use App\Models\User;

class CreateMarketingTestimonial
{
    private MarketingTestimonial $testimonialObject;

    public function __construct(
        private readonly User $user,
        private readonly string $nameToDisplay,
        private readonly string $testimony,
        private readonly ?string $urlToPointTo = null,
        private readonly bool $displayAvatar = false,
    ) {}

    public function execute(): MarketingTestimonial
    {
        $this->create();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
        $this->sendEmail();

        return $this->testimonialObject;
    }

    private function create(): void
    {
        $this->testimonialObject = MarketingTestimonial::create([
            'account_id' => $this->user->account_id,
            'user_id' => $this->user->id,
            'status' => MarketingTestimonialStatus::PENDING->value,
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
