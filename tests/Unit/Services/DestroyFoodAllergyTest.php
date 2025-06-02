<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\FoodAllergy;
use App\Models\Person;
use App\Models\User;
use App\Services\DestroyFoodAllergy;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyFoodAllergyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_food_allergy(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
            'food_allergies' => 'Peanuts',
        ]);

        (new DestroyFoodAllergy(
            user: $user,
            person: $person,
        ))->execute();

        $this->assertNull($person->fresh()->food_allergies);

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
            callback: function (UpdatePersonLastConsultedDate $job) use ($person): bool {
                return $job->person->id === $person->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'food_allergy_destroyed'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted a food allergy for Phoebe Buffay';
            },
        );
    }

    #[Test]
    public function it_throws_an_exception_if_the_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and person are not in the same account');

        (new DestroyFoodAllergy(
            user: $user,
            person: $person,
        ))->execute();
    }
}
