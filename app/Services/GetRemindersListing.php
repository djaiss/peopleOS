<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PeopleListCache;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class GetRemindersListing
{
    private array $monthColors = [
        1 => 'blue',    // January
        2 => 'purple',  // February
        3 => 'green',   // March
        4 => 'pink',    // April
        5 => 'amber',   // May
        6 => 'indigo',  // June
        7 => 'rose',    // July
        8 => 'teal',    // August
        9 => 'orange',  // September
        10 => 'cyan',   // October
        11 => 'violet', // November
        12 => 'red',    // December
    ];

    public function __construct(
        private readonly User $user,
        private readonly Person $person,
    ) {}

    public function execute(): array
    {
        $persons = PeopleListCache::make(
            accountId: $this->user->account_id,
        )->value();

        $this->person->load([
            'tasks' => function ($query): void {
                $query->with('taskCategory');
            },
            'specialDates' => function ($query): void {
                $query->where('should_be_reminded', true)
                    ->orderBy('month')
                    ->orderBy('day');
            },
        ]);

        $activeTasks = $this->getTasks($this->person, true);
        $completedTasks = $this->getTasks($this->person, false);

        $specialDatesCollection = $this->person->specialDates;

        $monthsData = $specialDatesCollection
            ->pluck('month')
            ->unique()
            ->values()
            ->map(fn($monthNumber): array => [
                'number' => $monthNumber,
                'name' => Carbon::create()->month($monthNumber)->translatedFormat('F'),
                'color' => $this->monthColors[$monthNumber] ?? '#FFFFFF',
                'reminders' => $specialDatesCollection
                    ->where('month', $monthNumber)
                    ->map(fn(SpecialDate $specialDate): array => [
                        'id' => $specialDate->id,
                        'day' => $specialDate->day,
                        'date' => $specialDate->date,
                        'name' => $specialDate->name,
                        'age' => $specialDate->age,
                    ])
                    ->values()
                    ->all(),
            ])
            ->values()
            ->all();

        return [
            'person' => $this->person,
            'persons' => $persons,
            'active_tasks' => $activeTasks,
            'completed_tasks' => $completedTasks,
            'months' => $monthsData,
            'total_reminders' => $specialDatesCollection->count(),
        ];
    }

    private function getTasks(Model $person, bool $completedStatus = false): Collection
    {
        return $person->tasks
            ->filter(fn(Task $task): bool => $task->is_completed === ! $completedStatus)
            ->map(fn(Task $task): array => [
                'id' => $task->id,
                'name' => $task->name,
                'due_at' => $task->due_at?->format('Y-m-d'),
                'is_completed' => $task->is_completed,
                'task_category' => $task->taskCategory ? [
                    'id' => $task->taskCategory->id,
                    'name' => $task->taskCategory->name,
                    'color' => $task->taskCategory->color,
                ] : null,
            ]);
    }
}
