<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Enums\EmailType;
use App\Jobs\SendReminder;
use App\Mail\ReminderSent;
use App\Models\Account;
use App\Models\EmailSent;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendReminderTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_a_reminder_when_instance_hasnt_enabled_paid_version(): void
    {
        config('peopleos.enable_paid_version', false);

        Mail::fake();
        Carbon::createFromDate(2011, 8, 19)->setTestNow();

        $account = Account::factory()->create();
        User::factory()->create([
            'account_id' => $account->id,
            'email' => 'ross.geller@friends.com',
        ]);
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $account->id,
            'name' => 'Birthday',
            'year' => 1969,
            'month' => 8,
            'day' => 19,
            'should_be_reminded' => true,
        ]);

        SendReminder::dispatch($specialDate);

        Mail::assertQueued(ReminderSent::class, function (ReminderSent $mail): bool {
            return $mail->hasTo('ross.geller@friends.com');
        });

        $emailSent = EmailSent::latest()->first();

        $this->assertEquals(EmailType::REMINDER_SENT->value, $emailSent->email_type);
        $this->assertEquals('ross.geller@friends.com', $emailSent->email_address);
        $this->assertEquals('Reminder for ' . $person->name, $emailSent->subject);
    }

    #[Test]
    public function it_does_not_send_a_reminder_when_the_instance_has_enabled_paid_version_and_the_trial_ended(): void
    {
        Config::set('peopleos.enable_paid_version', true);

        Mail::fake();

        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => Carbon::now()->subDays(2),
        ]);

        User::factory()->create([
            'account_id' => $account->id,
            'email' => 'ross.geller@friends.com',
        ]);
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $account->id,
            'name' => 'Birthday',
            'year' => 1969,
            'month' => 8,
            'day' => 19,
            'should_be_reminded' => true,
        ]);

        SendReminder::dispatch($specialDate);

        Mail::assertNotQueued(ReminderSent::class);
    }

    #[Test]
    public function it_sends_a_reminder_when_account_is_in_good_standing(): void
    {
        config('peopleos.enable_paid_version', true);

        Mail::fake();
        Carbon::createFromDate(2011, 8, 19)->setTestNow();

        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => Carbon::now()->addDays(1),
        ]);

        User::factory()->create([
            'account_id' => $account->id,
            'email' => 'ross.geller@friends.com',
        ]);
        $person = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $account->id,
            'name' => 'Birthday',
            'year' => 1969,
            'month' => 8,
            'day' => 19,
            'should_be_reminded' => true,
        ]);

        SendReminder::dispatch($specialDate);

        Mail::assertQueued(ReminderSent::class, function (ReminderSent $mail): bool {
            return $mail->hasTo('ross.geller@friends.com');
        });
    }

    #[Test]
    public function it_does_send_a_reminder_if_the_instance_has_restrictions_but_the_user_has_lifetime_access(): void
    {
        Mail::fake();
        Carbon::createFromDate(2011, 8, 19)->setTestNow();
        config('peopleos.enable_paid_version', true);
        $account = Account::factory()->create([
            'has_lifetime_access' => true,
            'trial_ends_at' => Carbon::now()->subDays(1),
        ]);

        User::factory()->create([
            'account_id' => $account->id,
            'email' => 'ross.geller@friends.com',
        ]);
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $account->id,
            'name' => 'Birthday',
            'year' => 1969,
            'month' => 8,
            'day' => 19,
            'should_be_reminded' => true,
        ]);

        SendReminder::dispatch($specialDate);

        Mail::assertQueued(ReminderSent::class, function (ReminderSent $mail): bool {
            return $mail->hasTo('ross.geller@friends.com');
        });
    }
}
