<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\AgeType;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use App\Services\UpdateAgeOfAPerson;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateAgeOfAPersonTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_exact_age(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'name' => 'Birthday',
        ]);
        $person->age_special_date_id = $specialDate->id;
        $person->save();

        $updatedPerson = (new UpdateAgeOfAPerson(
            user: $user,
            person: $person,
            ageType: AgeType::EXACT->value,
            estimatedAge: null,
            ageBracket: null,
            ageYear: 1967,
            ageMonth: 10,
            ageDay: 18,
            addYearlyReminder: true,
        ))->execute();

        $this->assertInstanceOf(
            Person::class,
            $updatedPerson
        );

        $this->assertDatabaseMissing('special_dates', [
            'id' => $specialDate->id,
        ]);

        $this->assertDatabaseHas('special_dates', [
            'id' => $person->refresh()->ageSpecialDate->id,
            'person_id' => $person->id,
            'year' => 1967,
            'month' => 10,
            'day' => 18,
        ]);

        $this->assertEquals(
            'Birthday',
            $person->ageSpecialDate->name,
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'age_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated the age of Ross Geller';
        });
    }

    #[Test]
    public function it_updates_estimated_age(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
        ]);

        (new UpdateAgeOfAPerson(
            user: $user,
            person: $person,
            ageType: AgeType::ESTIMATED->value,
            estimatedAge: 30,
            ageBracket: null,
            ageYear: null,
            ageMonth: null,
            ageDay: null,
            addYearlyReminder: false,
        ))->execute();

        Carbon::setTestNow(Carbon::parse('2045-03-17 10:00:00'));

        $this->assertEquals(50, $person->age);
        $this->assertNotNull($person->age_estimated_at);

        Queue::assertPushed(UpdateUserLastActivityDate::class);
        Queue::assertPushed(LogUserAction::class);
    }

    #[Test]
    public function it_updates_age_bracket(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
        ]);

        (new UpdateAgeOfAPerson(
            user: $user,
            person: $person,
            ageType: AgeType::BRACKET->value,
            estimatedAge: null,
            ageBracket: '30-35',
            ageYear: null,
            ageMonth: null,
            ageDay: null,
            addYearlyReminder: false,
        ))->execute();

        $this->assertEquals('30-35', $person->age_bracket);
        $this->assertNotNull($person->age_estimated_at);

        Queue::assertPushed(UpdateUserLastActivityDate::class);
        Queue::assertPushed(LogUserAction::class);
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateAgeOfAPerson(
            user: $user,
            person: $person,
            ageType: AgeType::EXACT->value,
            estimatedAge: null,
            ageBracket: null,
            ageYear: 1967,
            ageMonth: 10,
            ageDay: 18,
            addYearlyReminder: true,
        ))->execute();
    }
}
