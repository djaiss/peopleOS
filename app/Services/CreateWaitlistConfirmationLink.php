<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\URL;

/**
 * Create a temporary link so the user can confirm their inscription to the waitlist.
 * This link is valid for 30 minutes.
 */
class CreateWaitlistConfirmationLink
{
    private string $confirmationLink;

    public function __construct(
        private readonly string $code,
    ) {}

    public function execute(): string
    {
        $this->create();

        return $this->confirmationLink;
    }

    private function create(): void
    {
        $link = URL::temporarySignedRoute(
            'waitlist.confirm',
            now()->addMinutes(30),
            [
                'code' => $this->code,
            ],
        );

        $this->confirmationLink = $link;
    }
}
