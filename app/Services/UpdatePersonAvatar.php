<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PeopleListCache;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UpdatePersonAvatar
{
    private string $path;

    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        public $photo,
    ) {}

    /**
     * Update the profile picture of a person.
     */
    public function execute(): string
    {
        $this->deleteOldProfilePicture();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->log();
        $this->refreshCache();

        return $this->path;
    }

    private function deleteOldProfilePicture(): void
    {
        if ($this->person->profile_photo_path) {
            Storage::delete($this->person->profile_photo_path);
        }
    }

    private function update(): void
    {
        $this->path = $this->photo->storePublicly(path: 'avatars');
        $this->person->update([
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
            action: 'person_avatar_update',
            description: 'Updated the avatar of '.$this->person->name,
        );
    }

    private function refreshCache(): void
    {
        PeopleListCache::make(
            accountId: $this->user->account_id,
        )->refresh();
    }
}
