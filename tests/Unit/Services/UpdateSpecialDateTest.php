<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use App\Services\UpdateSpecialDate;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateSpecialDateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_special_date(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'name' => 'Wedding Anniversary',
            'year' => 1999,
            'month' => 5,
            'day' => 15,
            'should_be_reminded' => true,
        ]);

        $updatedSpecialDate = (new UpdateSpecialDate(
            user: $user,
            person: $person,
            specialDate: $specialDate,
            name: 'Vegas Wedding Anniversary',
            year: 1999,
            month: 6,
            day: 20,
            shouldBeReminded: false,
        ))->execute();

        $this->assertDatabaseHas('special_dates', [
            'id' => $specialDate->id,
            'person_id' => $person->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertEquals('Vegas Wedding Anniversary', $updatedSpecialDate->name);
        $this->assertEquals(1999, $updatedSpecialDate->year);
        $this->assertEquals(6, $updatedSpecialDate->month);
        $this->assertEquals(20, $updatedSpecialDate->day);
        $this->assertFalse($updatedSpecialDate->should_be_reminded);

        $this->assertInstanceOf(
            SpecialDate::class,
            $updatedSpecialDate
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });
    }

    #[Test]
    public function it_updates_a_special_date_with_partial_date(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'name' => 'Monthly Celebration',
            'year' => 1999,
            'month' => 5,
            'day' => 15,
            'should_be_reminded' => true,
        ]);

        $updatedSpecialDate = (new UpdateSpecialDate(
            user: $user,
            person: $person,
            specialDate: $specialDate,
            name: 'Monthly Celebration',
            year: null,
            month: 5,
            day: 15,
            shouldBeReminded: false,
        ))->execute();

        $this->assertDatabaseHas('special_dates', [
            'id' => $specialDate->id,
            'person_id' => $person->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertNull($updatedSpecialDate->year);
        $this->assertEquals(5, $updatedSpecialDate->month);
        $this->assertEquals(15, $updatedSpecialDate->day);
        $this->assertFalse($updatedSpecialDate->should_be_reminded);
    }

    #[Test]
    public function it_fails_if_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and person are not in the same account');

        (new UpdateSpecialDate(
            user: $user,
            person: $person,
            specialDate: $specialDate,
            name: 'Vegas Wedding Anniversary',
            year: 1999,
            month: 6,
            day: 20,
            shouldBeReminded: false,
        ))->execute();
    }

    #[Test]
    public function it_fails_if_special_date_is_not_associated_with_the_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $otherPerson = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $otherPerson->id,
            'account_id' => $user->account_id,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Special date is not associated with the person');

        (new UpdateSpecialDate(
            user: $user,
            person: $person,
            specialDate: $specialDate,
            name: 'Vegas Wedding Anniversary',
            year: 1999,
            month: 6,
            day: 20,
            shouldBeReminded: false,
        ))->execute();
    }
}
