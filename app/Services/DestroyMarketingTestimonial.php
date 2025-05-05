<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimonial;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyMarketingTestimonial
{
    public function __construct(
        private readonly User $user,
        private readonly MarketingTestimonial $testimonial,
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
        if ($this->user->account_id !== $this->testimonial->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function destroy(): void
    {
        $this->testimonial->delete();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'marketing_testimonial_deletion',
            description: 'Deleted a marketing testimonial',
        )->onQueue('low');
    }
}
