<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\FoodAllergy;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateFoodAllergy;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateFoodAllergyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_food_allergy(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $foodAllergy = (new CreateFoodAllergy(
            user: $user,
            person: $person,
            name: 'Peanuts',
        ))->execute();

        $this->assertDatabaseHas('food_allergies', [
            'id' => $foodAllergy->id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals(
            expected: 'Peanuts',
            actual: $foodAllergy->name,
        );

        $this->assertInstanceOf(
            expected: FoodAllergy::class,
            actual: $foodAllergy,
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
            callback: function (UpdatePersonLastConsultedDate $job) use ($person): bool {
                return $job->person->id === $person->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user, $person): bool {
                return $job->action === 'food_allergy_created'
                    && $job->user->id === $user->id
                    && $job->description === 'Created a food allergy for Chandler Bing: Peanuts';
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

        (new CreateFoodAllergy(
            user: $user,
            person: $person,
            name: 'Peanuts',
        ))->execute();
    }
}
