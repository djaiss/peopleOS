<?php

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use App\Services\StopSendingReminder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class StopSendingReminderTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_stops_sending_reminders()
    {
        Queue::fake();

        $account = Account::factory()->create();
        $user = User::factory()->create(['account_id' => $account->id]);
        $person = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
        $specialDate = SpecialDate::factory()->create([
            'account_id' => $account->id,
            'person_id' => $person->id,
            'should_be_reminded' => true,
        ]);

        (new StopSendingReminder(
            user: $user,
            specialDate: $specialDate)
        )->execute();

        $this->assertFalse($specialDate->fresh()->should_be_reminded);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function ($job) use ($user) {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function ($job) use ($user) {
            return $job->user->id === $user->id &&
                $job->action === 'stop_sending_reminder' &&
                $job->description === 'Marked a reminder as no longer sent for John Doe';
        });
    }

    /** @test */
    public function it_throws_an_exception_if_user_and_special_date_are_not_in_the_same_account()
    {
        $account1 = Account::factory()->create();
        $account2 = Account::factory()->create();
        $user = User::factory()->create(['account_id' => $account1->id]);
        $person = Person::factory()->create(['account_id' => $account2->id]);
        $specialDate = SpecialDate::factory()->create([
            'account_id' => $account2->id,
            'person_id' => $person->id,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User and special date are not in the same account');

        $service = new StopSendingReminder($user, $specialDate);
        $service->execute();
    }
}
