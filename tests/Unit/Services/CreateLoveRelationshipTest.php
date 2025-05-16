<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateLoveRelationship;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateLoveRelationshipTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_love_relationship(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $relatedPerson = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        $loveRelationship = (new CreateLoveRelationship(
            user: $user,
            person: $person,
            relatedPerson: $relatedPerson,
            type: 'Married',
            isCurrent: true,
            notes: 'Got married in Las Vegas',
        ))->execute();

        $this->assertDatabaseHas('love_relationships', [
            'id' => $loveRelationship->id,
            'person_id' => $person->id,
            'related_person_id' => $relatedPerson->id,
            'is_current' => true,
        ]);

        $this->assertDatabaseHas('love_relationships', [
            'person_id' => $relatedPerson->id,
            'related_person_id' => $person->id,
            'is_current' => true,
        ]);

        $this->assertEquals('Married', $loveRelationship->type);
        $this->assertEquals('Got married in Las Vegas', $loveRelationship->notes);

        $this->assertInstanceOf(
            LoveRelationship::class,
            $loveRelationship
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function ($job) use ($user): bool {
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
            callback: function ($job) use ($user): bool {
                return $job->action === 'love_relationship_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created a Married relationship between Ross Geller and Rachel Green';
            }
        );
    }

    #[Test]
    public function it_fails_if_persons_dont_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $relatedPerson = Person::factory()->create(); // Different account

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('One or both persons not found in user\'s account');

        (new CreateLoveRelationship(
            user: $user,
            person: $person,
            relatedPerson: $relatedPerson,
            type: 'Married',
        ))->execute();
    }

    #[Test]
    public function it_fails_if_relationship_already_exists(): void
    {
        $user = User::factory()->create();
        $ross = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $rachel = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        // Create initial relationship
        LoveRelationship::create([
            'person_id' => $ross->id,
            'related_person_id' => $rachel->id,
            'type' => 'Dating',
            'is_current' => true,
        ]);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Relationship already exists');

        (new CreateLoveRelationship(
            user: $user,
            person: $ross,
            relatedPerson: $rachel,
            type: 'Married',
        ))->execute();
    }
}
