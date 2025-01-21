<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Note;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateNote;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateNoteTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_note(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $note = (new CreateNote(
            user: $user,
            person: $person,
            content: 'This is a note',
        ))->execute();

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals('This is a note', $note->content);

        $this->assertInstanceOf(
            Note::class,
            $note
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'note_creation'
                && $job->user->id === $user->id
                && $job->description === 'Created a note for Chandler Bing';
        });
    }

    #[Test]
    public function it_throws_an_exception_if_the_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and person are not in the same account');

        (new CreateNote(
            user: $user,
            person: $person,
            content: 'This is a note',
        ))->execute();
    }
}
