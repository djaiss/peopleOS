<?php

declare(strict_types=1);

namespace App\Livewire\Administration;

use App\Models\User;
use App\Services\ToggleDisplayFullNames;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ToggleDisplayNames extends Component
{
    #[Locked]
    public User $user;

    public function mount(int $userId): void
    {
        $this->user = User::find($userId);
    }

    public function render()
    {
        return view('livewire.administration.toggle-display-names');
    }

    public function toggle(): void
    {
        (new ToggleDisplayFullNames(
            user: $this->user,
        ))->execute();

        Toaster::success(__('Changes saved'));

        $this->dispatch('display-names-updated');
    }
}
