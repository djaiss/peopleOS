<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Models\UserWaitlist;
use Exception;

class AddUserToWaitlist
{
    private UserWaitlist $waitlistEntry;

    public function __construct(
        private readonly string $email,
    ) {}

    public function execute(): UserWaitlist
    {
        $this->validate();
        $this->create();

        return $this->waitlistEntry;
    }

    private function validate(): void
    {
        if (UserWaitlist::where('email', $this->email)->exists()) {
            throw new Exception('User already in waitlist');
        }
    }

    private function create(): void
    {
        $this->waitlistEntry = UserWaitlist::create([
            'email' => $this->email,
        ]);
    }
}