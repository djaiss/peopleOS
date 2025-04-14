<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\EmailType;
use App\Mail\ReminderSent;
use App\Models\Account;
use App\Models\SpecialDate;
use App\Models\User;
use App\Services\CreateEmailSent;
use App\Services\CreateTask;
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
            ->select('id', 'email', 'account_id')
            ->get();

        foreach ($users as $user) {
            $this->sendReminderEmail($user);
            $this->recordEmailSent($user);
            $account->increment('emails_sent');

            // this should only be done once, since otherwise we would create
            // multiple tasks for the same reminder
            if ($user === $users->first()) {
                $this->createTaskOnReminder($user);
            }
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

    /**
     * Send the reminder email to the user.
     */
    public function sendReminderEmail(User $user): void
    {
        Mail::to($user->email)
            ->queue(new ReminderSent(
                name: $this->specialDate->name,
                slug: route('person.show', $this->specialDate->person->slug),
                personName: $this->specialDate->person->name,
                date: $this->specialDate->date,
                age: $this->specialDate->age,
                urlStopReminder: $this->prepareURLStopReminder(),
            ));
    }

    /**
     * Create a task on reminder.
     */
    public function createTaskOnReminder(User $user): void
    {
        if ($user->account->create_task_on_reminder) {
            (new CreateTask(
                user: $user,
                person: $this->specialDate->person,
                taskCategory: null,
                name: $this->specialDate->name.' - '.$this->specialDate->date,
                dueAt: null,
            ))->execute();
        }
    }

    private function recordEmailSent(User $user): void
    {
        (new CreateEmailSent(
            user: $user,
            emailType: EmailType::REMINDER_SENT->value,
            emailAddress: $user->email,
            subject: 'Reminder for '.$this->specialDate->person->name,
            body: (new ReminderSent(
                name: $this->specialDate->name,
                slug: route('person.show', $this->specialDate->person->slug),
                personName: $this->specialDate->person->name,
                date: $this->specialDate->date,
                age: $this->specialDate->age,
                urlStopReminder: $this->prepareURLStopReminder(),
            ))->render(),
            person: null,
        ))->execute();
    }
}
