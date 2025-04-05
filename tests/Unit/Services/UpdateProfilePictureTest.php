<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\UpdateProfilePicture;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProfilePictureTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_profile_picture(): void
    {
        Queue::fake();
        Storage::fake('local');
        config(['filesystems.default' => 'local']);

        $user = User::factory()->create();
        $photo = UploadedFile::fake()->image('avatar.jpg');

        $path = (new UpdateProfilePicture(
            user: $user,
            photo: $photo,
        ))->execute();

        // Assert the file was stored
        Storage::disk('local')->assertExists($path);

        // Assert the user's profile photo path was updated
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_photo_path' => $path,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'profile_picture_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated his/her profile picture';
            }
        );
    }

    #[Test]
    public function it_deletes_old_profile_picture_when_updating(): void
    {
        Queue::fake();
        Storage::fake('local');
        config(['filesystems.default' => 'local']);

        $user = User::factory()->create();

        // Upload initial photo
        $oldPhoto = UploadedFile::fake()->image('old-avatar.jpg');
        $oldPath = (new UpdateProfilePicture(
            user: $user,
            photo: $oldPhoto,
        ))->execute();

        // Upload new photo
        $newPhoto = UploadedFile::fake()->image('new-avatar.jpg');
        $newPath = (new UpdateProfilePicture(
            user: $user,
            photo: $newPhoto,
        ))->execute();

        // Assert old file was deleted
        Storage::disk('local')->assertMissing($oldPath);

        // Assert new file exists
        Storage::disk('local')->assertExists($newPath);

        // Assert database was updated
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_photo_path' => $newPath,
        ]);
    }
}
