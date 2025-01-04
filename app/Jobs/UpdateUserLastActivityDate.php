<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateUserLastActivityDate implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
    ) {
    }

    public function handle(): void
    {
        $this->user->last_activity_at = now();
        $this->user->save();
    }
}
