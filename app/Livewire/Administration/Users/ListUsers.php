<?php

declare(strict_types=1);

namespace App\Livewire\Administration\Users;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class ListUsers extends Component
{
    #[Locked]
    public Collection $users;

    public function mount(): void
    {
        $this->users = $this->getUsers();
    }

    public function render()
    {
        return view('livewire.administration.users.list-users');
    }

    public function getUsers(): Collection
    {
        return User::where('account_id', Auth::user()->account_id)
            ->orderBy('last_name', 'asc')
            ->get()
            ->map(fn (User $user): array => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
                'last_activity_at' => $user->last_activity_at?->format('Y-m-d H:i:s'),
                'profile_photo_url' => $user->profile_photo_url,
            ]);
    }

    #[On('user-invited')]
    public function refreshUsers(): void
    {
        $this->users = $this->getUsers();
    }
}
