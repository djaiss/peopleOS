<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\Task;
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
        $persons = $this->getLatestSeenPersons();
        $quote = $this->getInspirationalQuote();
        $tasks = $this->getTasks();

        return [
            'reminders' => $reminders,
            'persons' => $persons,
            'quote' => $quote,
            'tasks' => $tasks,
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
                    ],
                ]);
            }
        }

        return $reminderCollection;
    }

    public function getLatestSeenPersons(): Collection
    {
        $persons = Person::where('account_id', $this->user->account_id)
            ->orderBy('last_consulted_at', 'desc')
            ->limit(5)
            ->get();

        return $persons->map(fn(Person $person): array => [
            'id' => $person->id,
            'name' => $person->name,
            'slug' => $person->slug,
            'avatar' => [
                '40' => $person->getAvatar(40),
                '80' => $person->getAvatar(80),
            ],
            'last_consulted_at' => $person->last_consulted_at->diffForHumans(),
        ]);
    }

    public function getInspirationalQuote(): string
    {
        $kindMessages = [
            trans_key("Hope you're doing great today."),
            trans_key("Just checking in—hope all is well with you."),
            trans_key("Wishing you a calm and happy day."),
            trans_key("Sending good vibes your way."),
            trans_key("Hope you’re feeling your best today."),
            trans_key("We sincerely hope that you are fine."),
            trans_key("Take it easy today—you deserve it."),
            trans_key("Hope life’s being kind to you."),
            trans_key("Thinking of you and hoping you’re well."),
            trans_key("Hope you're surrounded by good energy."),
            trans_key("Wishing you peace and clarity today."),
            trans_key("Stay strong and keep shining."),
            trans_key("Hope you're smiling right now."),
            trans_key("We trust this note finds you in good spirits."),
            trans_key("Hang in there—you're doing great."),
            trans_key("Wishing you a moment to breathe and relax."),
            trans_key("Hope something nice surprises you today."),
            trans_key("Wishing you the little joys that make a big difference."),
            trans_key("You're on our minds—hope things are going smoothly."),
            trans_key("Hope your day has a little sparkle to it."),
            trans_key("Take care of yourself—you matter."),
            trans_key("Hope the sun's shining where you are."),
            trans_key("Wishing you rest, laughter, and good coffee."),
            trans_key("Stay cozy, stay kind."),
            trans_key("We’re sending you a little kindness today."),
            trans_key("Hope your inbox is light and your coffee is strong."),
            trans_key("Just a little note to say we care."),
            trans_key("Wishing you more smiles than emails today."),
            trans_key("Hope you're catching your breath and taking it slow."),
            trans_key("We’re rooting for you—always."),
            trans_key("Hope you’re getting the break you need."),
            trans_key("Thinking of you—hope today’s been gentle."),
            trans_key("May your day be peaceful and your Wi-Fi strong."),
            trans_key("You got this—whatever 'this' is."),
            trans_key("Hope you’re laughing at least once today."),
            trans_key("Hope your socks match and your plans go smoothly."),
            trans_key("Here’s to a day that’s better than expected."),
            trans_key("May your coffee be hot and your meetings short."),
            trans_key("Hope something simple makes you smile today."),
            trans_key("Sending a virtual high-five your way."),
            trans_key("Hope your day feels just right."),
            trans_key("Sending calm thoughts and friendly waves."),
            trans_key("Wishing you a moment to do absolutely nothing."),
            trans_key("We hope this finds you safe and sound."),
            trans_key("Hope today brings you something sweet—even if it’s a cookie."),
            trans_key("Sending a little reminder: you’re doing better than you think."),
            trans_key("Wishing you patience, peace, and maybe a nap."),
            trans_key("Just here to say: hope you’re okay."),
            trans_key("Wishing you good luck, good timing, and good snacks."),
            trans_key("Here’s to steady steps and quiet wins."),
        ];

        return __($kindMessages[array_rand($kindMessages)]);
    }

    public function getTasks(): Collection
    {
        $tasks = Task::where('account_id', $this->user->account_id)
            ->with('person')
            ->with('taskCategory')
            ->where('is_completed', false)
            ->orderBy('due_at', 'asc')
            ->get();

        return $tasks->map(fn(Task $task): array => [
            'id' => $task->id,
            'name' => $task->name,
            'task_category' => [
                'id' => $task->taskCategory?->id,
                'name' => $task->taskCategory?->name,
                'color' => $task->taskCategory?->color,
            ],
            'due_at' => $task->due_at?->format('Y-m-d'),
            'person' => [
                'id' => $task->person->id,
                'name' => $task->person->name,
                'slug' => $task->person->slug,
                'avatar' => [
                    '40' => $task->person->getAvatar(40),
                    '80' => $task->person->getAvatar(80),
                ],
            ],
        ]);
    }
}
