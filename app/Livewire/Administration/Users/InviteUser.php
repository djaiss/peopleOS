<?php

declare(strict_types=1);

namespace App\Livewire\Administration\Users;

use App\Services\InviteUser as InviteUserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class InviteUser extends Component
{
    #[Validate('required|email|unique:users,email')]
    public string $email = '';

    public function render()
    {
        return view('livewire.administration.users.invite-user');
    }

    public function store(): void
    {
        $this->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        (new InviteUserService(
            user: Auth::user(),
            email: $this->email,
        ))->execute();

        Toaster::success(__('User invited'));

        $this->reset('email');

        $this->dispatch('user-invited');
        $this->dispatch('store-complete');
    }
}
