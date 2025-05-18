<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use App\Services\CreateSpecialDate;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateSpecialDateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_special_date(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $specialDate = (new CreateSpecialDate(
            user: $user,
            person: $person,
            name: 'Wedding Anniversary',
            year: 1999,
            month: 5,
            day: 15,
            shouldBeReminded: true,
        ))->execute();

        $this->assertDatabaseHas('special_dates', [
            'id' => $specialDate->id,
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'should_be_reminded' => true,
        ]);

        $this->assertEquals('Wedding Anniversary', $specialDate->name);
        $this->assertTrue($specialDate->should_be_reminded);

        $this->assertInstanceOf(
            SpecialDate::class,
            $specialDate,
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            },
        );
    }

    #[Test]
    public function it_creates_a_special_date_with_partial_date(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $specialDate = (new CreateSpecialDate(
            user: $user,
            person: $person,
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
            'year' => null,
            'month' => 5,
            'day' => 15,
            'should_be_reminded' => false,
        ]);

        $this->assertEquals('Monthly Celebration', $specialDate->name);
    }

    #[Test]
    public function it_fails_if_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User and person are not in the same account');

        (new CreateSpecialDate(
            user: $user,
            person: $person,
            name: 'Wedding Anniversary',
            year: 1999,
            month: 5,
            day: 15,
            shouldBeReminded: true,
        ))->execute();
    }
}
