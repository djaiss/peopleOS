<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;

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
            (new DestroyImageAndVariants(
                path: $this->user->profile_photo_path,
            ))->execute();
        }
    }

    private function update(): void
    {
        $this->path = $this->photo->storePublicly(path: 'avatars');
        $this->user->update([
            'profile_photo_path' => $this->path,
        ]);

        (new ResizeImage(
            path: $this->path,
            maxWidth: 32,
            maxHeight: 32,
        ))->execute();

        (new ResizeImage(
            path: $this->path,
            maxWidth: 64,
            maxHeight: 64,
        ))->execute();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'profile_picture_update',
            description: 'Updated his/her profile picture',
        )->onQueue('low');
    }
}
