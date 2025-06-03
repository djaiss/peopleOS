<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Child;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdateChild;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_child_relationship(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $originalParent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $originalSecondParent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        $child = Child::factory()->create([
            'account_id' => $user->account_id,
            'parent_id' => $originalParent->id,
            'second_parent_id' => $originalSecondParent->id,
            'first_name' => 'Emma',
            'last_name' => 'Geller-Green',
        ]);

        $newParent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);
        $newSecondParent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $updatedChild = (new UpdateChild(
            user: $user,
            child: $child,
            parent: $newParent,
            secondParent: $newSecondParent,
            firstName: 'Ben',
            lastName: 'Geller-Bing',
        ))->execute();

        $this->assertDatabaseHas('children', [
            'id' => $updatedChild->id,
            'account_id' => $user->account_id,
            'parent_id' => $newParent->id,
            'second_parent_id' => $newSecondParent->id,
        ]);

        $this->assertEquals('Ben', $updatedChild->first_name);
        $this->assertEquals('Geller-Bing', $updatedChild->last_name);

        $this->assertInstanceOf(
            Child::class,
            $updatedChild,
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
            job: LogUserAction::class,
            callback: function ($job) use ($user): bool {
                return $job->action === 'child_relationship_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated a child for Monica Geller and Chandler Bing';
            },
        );
    }

    #[Test]
    public function it_updates_a_child_with_one_parent_only(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $originalParent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $child = Child::factory()->create([
            'account_id' => $user->account_id,
            'parent_id' => $originalParent->id,
            'second_parent_id' => null,
            'first_name' => 'Emma',
            'last_name' => 'Geller',
        ]);

        $newParent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);

        $updatedChild = (new UpdateChild(
            user: $user,
            child: $child,
            parent: $newParent,
            firstName: 'Ben',
            lastName: 'Buffay',
        ))->execute();

        $this->assertDatabaseHas('children', [
            'id' => $updatedChild->id,
            'parent_id' => $newParent->id,
            'second_parent_id' => null,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function ($job) use ($user): bool {
                return $job->action === 'child_relationship_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated a child for Phoebe Buffay';
            },
        );
    }

    #[Test]
    public function it_updates_a_child_with_no_parents(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $child = Child::factory()->create([
            'account_id' => $user->account_id,
            'parent_id' => null,
            'second_parent_id' => null,
            'first_name' => 'Emma',
            'last_name' => 'Geller',
        ]);

        $updatedChild = (new UpdateChild(
            user: $user,
            child: $child,
            firstName: 'Ben',
            lastName: 'Bing',
        ))->execute();

        $this->assertDatabaseHas('children', [
            'id' => $updatedChild->id,
            'parent_id' => null,
            'second_parent_id' => null,
        ]);

        $this->assertEquals('Ben', $updatedChild->first_name);
        $this->assertEquals('Bing', $updatedChild->last_name);

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function ($job) use ($user): bool {
                return $job->action === 'child_relationship_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated a child for no one';
            },
        );
    }

    #[Test]
    public function it_fails_if_child_doesnt_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $child = Child::factory()->create([
            'account_id' => $otherUser->account_id,
        ]);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Child not found in user\'s account');

        (new UpdateChild(
            user: $user,
            child: $child,
            firstName: 'Ben',
            lastName: 'Bing',
        ))->execute();
    }

    #[Test]
    public function it_fails_if_parent_doesnt_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $child = Child::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $parent = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Parent not found in user\'s account');

        (new UpdateChild(
            user: $user,
            child: $child,
            parent: $parent,
            firstName: 'Ben',
            lastName: 'Bing',
        ))->execute();
    }

    #[Test]
    public function it_fails_if_second_parent_doesnt_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $child = Child::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $parent = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $secondParent = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Second parent not found in user\'s account');

        (new UpdateChild(
            user: $user,
            child: $child,
            parent: $parent,
            secondParent: $secondParent,
            firstName: 'Ben',
            lastName: 'Bing',
        ))->execute();
    }
}
