<?php

declare(strict_types=1);

namespace App\Livewire\Administration;

use App\Models\User;
use App\Services\ToggleDisplayFullNames;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

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

    public function toggle(): Redirector
    {
        (new ToggleDisplayFullNames(
            user: $this->user,
        ))->execute();

        return redirect()->route('administration.index')
            ->success(trans('Changes saved'));
    }
}
