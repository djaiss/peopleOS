<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Log;
use App\Models\User;

class GetSubsetOfLogs
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function execute(): array
    {
        $logs = Log::where('user_id', $this->user->id)
            ->with('user')
            ->take(5)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Log $log): array => [
                'user' => [
                    'name' => $log->name,
                ],
                'action' => $log->action,
                'description' => $log->description,
                'created_at' => $log->created_at->diffForHumans(),
            ]);

        $has_more_logs = Log::where('user_id', $this->user->id)->count() > 5;

        return [
            'logs' => $logs,
            'has_more_logs' => $has_more_logs,
        ];
    }
}
