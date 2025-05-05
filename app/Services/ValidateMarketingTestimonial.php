<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\MarketingTestimonialStatus;
use App\Jobs\SendMarketingTestimonialReviewedEmail;
use App\Models\MarketingTestimonial;
use App\Models\User;
use Exception;

class ValidateMarketingTestimonial
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingTestimonial $testimonial,
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
            throw new Exception('User must be an instance administrator to validate a testimonial.');
        }
    }

    private function updateStatus(): void
    {
        $this->testimonial->update([
            'status' => MarketingTestimonialStatus::APPROVED->value,
        ]);
    }

    private function sendEmail(): void
    {
        $user = User::where('id', $this->testimonial->user_id)
            ->first();

        SendMarketingTestimonialReviewedEmail::dispatch(
            email: $user->email,
        )->onQueue('high');
    }
}
