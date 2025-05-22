<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Child;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateChild;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_child_relationship(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $child = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Emma',
            'last_name' => 'Geller-Green',
        ]);
        $parent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $secondParent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        $childRelationship = (new CreateChild(
            user: $user,
            person: $child,
            parent: $parent,
            secondParent: $secondParent,
            notes: 'Born in 2002',
        ))->execute();

        $this->assertDatabaseHas('children', [
            'id' => $childRelationship->id,
            'person_id' => $child->id,
            'parent_id' => $parent->id,
            'second_parent_id' => $secondParent->id,
        ]);

        $this->assertEquals('Born in 2002', $childRelationship->notes);

        $this->assertInstanceOf(
            Child::class,
            $childRelationship,
        );

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
            callback: function (UpdatePersonLastConsultedDate $job) use ($parent): bool {
                return $job->person->id === $parent->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function ($job) use ($user): bool {
                return $job->action === 'child_relationship_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created a child between Ross Geller and Rachel Green';
            },
        );
    }

    #[Test]
    public function it_creates_a_child_relationship_without_second_parent(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $child = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Emma',
            'last_name' => 'Geller-Green',
        ]);
        $parent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $childRelationship = (new CreateChild(
            user: $user,
            person: $child,
            parent: $parent,
            notes: 'Born in 2002',
        ))->execute();

        $this->assertDatabaseHas('children', [
            'id' => $childRelationship->id,
            'person_id' => $child->id,
            'parent_id' => $parent->id,
            'second_parent_id' => null,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function ($job) use ($user): bool {
                return $job->action === 'child_relationship_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created a child between Ross Geller';
            },
        );
    }

    #[Test]
    public function it_fails_if_persons_dont_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $child = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $parent = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('One or more persons not found in user\'s account');

        (new CreateChild(
            user: $user,
            person: $child,
            parent: $parent,
        ))->execute();
    }

    #[Test]
    public function it_fails_if_relationship_already_exists(): void
    {
        $user = User::factory()->create();
        $child = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $parent = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Child::create([
            'person_id' => $child->id,
            'parent_id' => $parent->id,
        ]);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Child relationship already exists');

        (new CreateChild(
            user: $user,
            person: $child,
            parent: $parent,
        ))->execute();
    }
}
