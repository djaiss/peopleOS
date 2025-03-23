<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\ReminderSent;
use App\Models\Account;
use App\Models\SpecialDate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendReminder implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public SpecialDate $specialDate
    ) {}

    /**
     * Send the reminder.
     */
    public function handle(): void
    {
        $user = Account::query()
            ->with(['users' => function ($query): void {
                $query->orderBy('created_at', 'asc')
                    ->limit(1);
            }])
            ->first()
            ->users
            ->first();

        Mail::to($user->email)
            ->queue(new ReminderSent(
                name: $this->specialDate->name,
                slug: route('person.show', $this->specialDate->person->slug),
                personName: $this->specialDate->person->name,
                date: $this->specialDate->date,
                age: $this->specialDate->age,
            ));
    }
}
