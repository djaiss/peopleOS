<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UpdateProfilePicture
{
    private string $path;

    public function __construct(
        public User $user,
        public $photo,
    ) {}

    /**
     * Update the profile picture of a user.
     */
    public function execute(): string
    {
        $this->deleteOldProfilePicture();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->path;
    }

    private function deleteOldProfilePicture(): void
    {
        if ($this->user->profile_photo_path) {
            Storage::delete($this->user->profile_photo_path);
        }
    }

    private function update(): void
    {
        $this->path = $this->photo->storePublicly(path: 'photos');
        $this->user->update([
            'profile_photo_path' => $this->path,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'profile_picture_update',
            description: 'Updated his/her profile picture',
        );
    }
}
