<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\ResizePersonAvatar;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdatePersonAvatar;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePersonAvatarTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_person_avatar(): void
    {
        Queue::fake();
        Storage::fake('local');
        config(['filesystems.default' => 'local']);

        $user = User::factory()->create();
        $person = Person::factory()->create();
        $photo = UploadedFile::fake()->image('avatar.jpg');

        $path = (new UpdatePersonAvatar(
            user: $user,
            person: $person,
            photo: $photo,
        ))->execute();

        // Assert the file was stored
        Storage::disk('local')->exists($path);
        $this->assertTrue(Storage::disk('local')->exists($path));

        // Assert the person's profile photo path was updated
        $this->assertDatabaseHas('persons', [
            'id' => $person->id,
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
            queue: 'high',
            job: ResizePersonAvatar::class,
            callback: function (ResizePersonAvatar $job) use ($person): bool {
                return $job->person->id === $person->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdatePersonLastConsultedDate::class,
            callback: function (UpdatePersonLastConsultedDate $job) use ($person): bool {
                return $job->person->id === $person->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user, $person): bool {
                return $job->action === 'person_avatar_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated the avatar of '.$person->name;
            }
        );
    }

    #[Test]
    public function it_deletes_old_avatar_when_updating(): void
    {
        Queue::fake();
        Storage::fake('local');
        config(['filesystems.default' => 'local']);

        $user = User::factory()->create();
        $person = Person::factory()->create();

        // Upload initial photo
        $oldPhoto = UploadedFile::fake()->image('old-avatar.jpg');
        $oldPath = (new UpdatePersonAvatar(
            user: $user,
            person: $person,
            photo: $oldPhoto,
        ))->execute();

        // Upload new photo
        $newPhoto = UploadedFile::fake()->image('new-avatar.jpg');
        $newPath = (new UpdatePersonAvatar(
            user: $user,
            person: $person,
            photo: $newPhoto,
        ))->execute();

        // Assert old file was deleted
        $this->assertFalse(Storage::disk('local')->exists($oldPath));

        // Assert new file exists
        $this->assertTrue(Storage::disk('local')->exists($newPath));

        // Assert database was updated
        $this->assertDatabaseHas('persons', [
            'id' => $person->id,
            'profile_photo_path' => $newPath,
        ]);
    }
}
