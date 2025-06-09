<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Child;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdateChildFoodAllergy;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateChildFoodAllergyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_child_food_allergy(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $parent = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $child = Child::factory()->create([
            'account_id' => $user->account_id,
            'parent_id' => $parent->id,
            'second_parent_id' => null,
            'first_name' => 'Ben',
            'last_name' => 'Geller',
        ]);

        $child = (new UpdateChildFoodAllergy(
            user: $user,
            child: $child,
            name: 'Peanuts',
        ))->execute();

        $this->assertEquals(
            expected: 'Peanuts',
            actual: $child->food_allergies,
        );

        $this->assertInstanceOf(
            expected: Child::class,
            actual: $child,
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
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
            callback: function (LogUserAction $job) use ($user, $child): bool {
                return $job->action === 'child_food_allergy_updated'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated a food allergy for Ben Geller: Peanuts';
            },
        );
    }

    #[Test]
    public function it_throws_an_exception_if_the_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $child = Child::factory()->create();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and child are not in the same account');

        (new UpdateChildFoodAllergy(
            user: $user,
            child: $child,
            name: 'Peanuts',
        ))->execute();
    }
}
