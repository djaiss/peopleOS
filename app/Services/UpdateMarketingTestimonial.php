<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MarketingTestimonialStatus;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimonial;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateMarketingTestimonial
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingTestimonial $testimonialObject,
        private readonly ?string $nameToDisplay = null,
        private readonly ?string $testimony = null,
        private readonly ?string $urlToPointTo = null,
        private readonly ?bool $displayAvatar = null,
    ) {}

    public function execute(): MarketingTestimonial
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->testimonialObject;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->testimonialObject->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->testimonialObject->update([
            'status' => MarketingTestimonialStatus::PENDING->value,
            'name_to_display' => $this->nameToDisplay ?? $this->testimonialObject->name_to_display,
            'testimony' => $this->testimony ?? $this->testimonialObject->testimony,
            'url_to_point_to' => $this->urlToPointTo ?? $this->testimonialObject->url_to_point_to,
            'display_avatar' => $this->displayAvatar ?? $this->testimonialObject->display_avatar,
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
            action: 'marketing_testimonial_update',
            description: 'Updated a marketing testimonial',
        )->onQueue('low');
    }
}
