<?php

declare(strict_types=1);

namespace App\Livewire\Administration;

use App\Models\User;
use App\Services\UpdateProfilePicture;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Masmerise\Toaster\Toaster;

class ManageAvatar
{
    public $photo;

    public $avatarUrl;

    #[Locked]
    public User $user;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->refreshAvatarUrl();
    }

    public function render()
    {
        return view('livewire.administration.manage-avatar');
    }

    public function store(): void
    {
        $this->validate([
            'photo' => 'image|max:2000',
        ]);

        (new UpdateProfilePicture(
            user: $this->user,
            photo: $this->photo,
        ))->execute();

        // After successful upload
        $this->refreshAvatarUrl();
        $this->dispatch('avatar-updated');
        Toaster::success(__('Changes saved'));
    }

    private function refreshAvatarUrl(): void
    {
        $this->avatarUrl = $this->user->getAvatar(58);
    }
}
