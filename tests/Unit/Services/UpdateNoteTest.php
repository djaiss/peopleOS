<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Note;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdateNote;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateNoteTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_note(): void
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

        $note = (new UpdateNote(
            user: $user,
            note: $note,
            content: 'This is a new note',
        ))->execute();

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals('This is a new note', $note->content);

        $this->assertInstanceOf(
            Note::class,
            $note
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
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
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'note_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated the note for Chandler Bing';
            }
        );
    }

    #[Test]
    public function it_throws_an_exception_if_the_user_and_note_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $note = Note::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and note are not in the same account');

        (new UpdateNote(
            user: $user,
            note: $note,
            content: 'This is a new note',
        ))->execute();
    }
}
