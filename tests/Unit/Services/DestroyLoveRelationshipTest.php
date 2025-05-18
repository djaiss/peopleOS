<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Models\User;
use App\Services\DestroyLoveRelationship;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyLoveRelationshipTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_deletes_a_love_relationship(): void
    {
        Queue::fake();

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

        $loveRelationship = LoveRelationship::create([
            'person_id' => $ross->id,
            'related_person_id' => $rachel->id,
            'type' => 'Married',
            'is_current' => true,
            'notes' => 'Got married in Las Vegas',
        ]);

        (new DestroyLoveRelationship(
            user: $user,
            loveRelationship: $loveRelationship,
        ))->execute();

        $this->assertDatabaseMissing('love_relationships', [
            'person_id' => $ross->id,
            'related_person_id' => $rachel->id,
        ]);

        $this->assertDatabaseMissing('love_relationships', [
            'person_id' => $rachel->id,
            'related_person_id' => $ross->id,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function ($job) use ($user): bool {
                return $job->user->id === $user->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdatePersonLastConsultedDate::class,
            callback: function (UpdatePersonLastConsultedDate $job) use ($ross, $rachel): bool {
                return $job->person->id === $ross->id || $job->person->id === $rachel->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function ($job) use ($user): bool {
                return $job->action === 'love_relationship_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted a Married relationship between Ross Geller and Rachel Green';
            },
        );
    }

    #[Test]
    public function it_fails_if_relationship_doesnt_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $ross = Person::factory()->create([
            'account_id' => $otherUser->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $rachel = Person::factory()->create([
            'account_id' => $otherUser->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        $loveRelationship = LoveRelationship::create([
            'person_id' => $ross->id,
            'related_person_id' => $rachel->id,
            'type' => 'Married',
            'is_current' => true,
        ]);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Relationship not found in user\'s account');

        (new DestroyLoveRelationship(
            user: $user,
            loveRelationship: $loveRelationship,
        ))->execute();
    }
}
