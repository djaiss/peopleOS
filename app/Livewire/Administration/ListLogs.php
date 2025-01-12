<?php

declare(strict_types=1);

namespace App\Livewire\Administration;

use App\Models\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class ListLogs extends Component
{
    #[Locked]
    public Collection $logs;

    #[Locked]
    public bool $has_more_logs = false;

    public function mount(): void
    {
        $this->getLogs();
    }

    public function render()
    {
        return view('livewire.administration.list-logs');
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col space-y-2 mb-3">
                <div class="animate-pulse bg-slate-200 h-10 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-10 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-10 w-full rounded-xl"></div>
            </div>
        </div>
        HTML;
    }

    #[On('avatar-updated')]
    #[On('display-names-updated')]
    #[On('profile-updated')]
    public function getLogs(): void
    {
        $this->logs = Log::where('user_id', Auth::user()->id)
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

        $this->has_more_logs = Log::where('user_id', Auth::user()->id)->count() > 5;
    }
}
