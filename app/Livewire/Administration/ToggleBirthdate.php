<?php

declare(strict_types=1);

namespace App\Livewire\Administration;

use App\Models\User;
use App\Services\ToggleBirthdate as ToggleBirthdateService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Masmerise\Toaster\Toaster;

class ToggleBirthdate
{
    #[Locked]
    public User $user;

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.administration.toggle-birthdate');
    }

    public function toggle(): void
    {
        (new ToggleBirthdateService(
            user: $this->user,
        ))->execute();

        Toaster::success(__('Changes saved'));

        $this->dispatch('birthdate-updated');
    }
}
