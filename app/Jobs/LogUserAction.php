<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Log;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LogUserAction implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        public string $action,
        public string $description,
    ) {}

    /**
     * Log the user action in the logs table.
     * The action is the key in the organizationos.php config file.
     */
    public function handle(): void
    {
        Log::create([
            'account_id' => $this->user->account_id,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'action' => $this->action,
            'description' => $this->description,
        ]);
    }
}
