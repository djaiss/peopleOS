<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MarketingTestimonialStatus;
use App\Jobs\SendMarketingTestimonialRejectedEmail;
use App\Models\MarketingTestimonial;
use App\Models\User;
use Exception;

class RejectMarketingTestimonial
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingTestimonial $testimonial,
        private readonly string $reason,
    ) {}

    public function execute(): MarketingTestimonial
    {
        $this->validate();
        $this->updateStatus();
        $this->sendEmail();

        return $this->testimonial;
    }

    private function validate(): void
    {
        if (! $this->user->is_instance_admin) {
            throw new Exception('User must be an instance administrator to reject a testimonial.');
        }
    }

    private function updateStatus(): void
    {
        $this->testimonial->update([
            'status' => MarketingTestimonialStatus::REJECTED->value,
        ]);
    }

    private function sendEmail(): void
    {
        SendMarketingTestimonialRejectedEmail::dispatch(
            email: $this->user->email,
            reason: $this->reason,
        )->onQueue('high');
    }
}
