<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\SendReminder;
use App\Mail\ReminderSent;
use App\Models\Account;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendReminderTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_a_reminder(): void
    {
        Mail::fake();
        Carbon::createFromDate(2011, 8, 19)->setTestNow();

        $account = Account::factory()->create();
        $user = User::factory()->create([
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

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'emails_sent' => 1,
        ]);
    }
}
