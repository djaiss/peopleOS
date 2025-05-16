<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PeopleListCache;
use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class GetDashboardInformation
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function execute(): array
    {
        $reminders = $this->getReminders();

        return [
            'reminders' => $reminders,
        ];
    }

    public function getReminders(): Collection
    {
        $monthIn30Days = now()->addDays(30)->month;

        // get the reminders for the next 30 days
        $reminders = SpecialDate::where('should_be_reminded', true)
            ->where('account_id', $this->user->account_id)
            ->where('month', '<=', $monthIn30Days)
            ->where('month', '>=', now()->month)
            ->with('person')
            ->orderBy('month')
            ->orderBy('day')
            ->get();

        $reminderCollection = collect([]);

        foreach ($reminders as $reminder) {
            $carbonDate = Carbon::parse(now()->year . '-' . $reminder->month . '-' . $reminder->day);

            if ($carbonDate->between(now(), now()->addDays(30))) {
                $reminderCollection->push([
                    'id' => $reminder->id,
                    'name' => $reminder->name,
                    'month' => Carbon::create()->month($reminder->month)->translatedFormat('M'),
                    'day' => sprintf('%02d', $reminder->day),
                    'person' => [
                        'id' => $reminder->person->id,
                        'name' => $reminder->person->name,
                        'slug' => $reminder->person->slug,
                        'avatar' => [
                            '40' => $reminder->person->getAvatar(40),
                            '80' => $reminder->person->getAvatar(80),
                        ],
                    ]
                ]);
            }
        }

        return $reminderCollection;
    }
}
