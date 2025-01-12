<?php

declare(strict_types=1);

namespace App\Livewire\Administration\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageAvatar extends Component
{
    use WithFileUploads;

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
        return view('livewire.administration.users.manage-avatar');
    }

    public function store(): void
    {
        $this->validate([
            'photo' => 'image|max:2000',
        ]);

        $path = $this->photo->storePublicly(path: 'photos');
        $this->user->update([
            'profile_photo_path' => $path,
        ]);

        // After successful upload
        $this->refreshAvatarUrl();
        $this->dispatch('avatar-updated');
    }

    private function refreshAvatarUrl(): void
    {
        $this->avatarUrl = $this->user->profile_photo_url;
    }
}
