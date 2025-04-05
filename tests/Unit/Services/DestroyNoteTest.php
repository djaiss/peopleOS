<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Note;
use App\Models\Person;
use App\Models\User;
use App\Services\DestroyNote;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyNoteTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_note(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);
        $note = Note::factory()->create([
            'person_id' => $person->id,
        ]);

        (new DestroyNote(
            user: $user,
            note: $note,
        ))->execute();

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
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
                return $job->action === 'note_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted a note for Chandler Bing';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $note = Note::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and note are not in the same account');

        (new DestroyNote(
            user: $user,
            note: $note,
        ))->execute();
    }
}
