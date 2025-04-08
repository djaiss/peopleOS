<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\ReminderSent;
use App\Models\Account;
use App\Models\SpecialDate;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendReminder implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public SpecialDate $specialDate
    ) {}

    /**
     * Send the reminder to all users of the account.
     */
    public function handle(): void
    {
        $account = Account::find($this->specialDate->account_id);

        if ($account->needsToPay()) {
            return;
        }

        $users = User::where('account_id', $this->specialDate->account_id)
            ->select('email')
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)
                ->queue(new ReminderSent(
                    name: $this->specialDate->name,
                    slug: route('person.show', $this->specialDate->person->slug),
                    personName: $this->specialDate->person->name,
                    date: $this->specialDate->date,
                    age: $this->specialDate->age,
                    urlStopReminder: $this->prepareURLStopReminder(),
                ));

            $account->increment('emails_sent');
        }
    }

    /**
     * We provide an url to let users unsubscribe from reminders for this special
     * date.
     */
    public function prepareURLStopReminder(): string
    {
        return URL::signedRoute('reminder.stop', [
            'hash' => Crypt::encryptString($this->specialDate->person->id),
            'id' => $this->specialDate->id,
        ]);
    }
}
