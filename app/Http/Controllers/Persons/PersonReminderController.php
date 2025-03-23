<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Cache\PeopleListCache;
use App\Http\Controllers\Controller;
use App\Models\SpecialDate;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonReminderController extends Controller
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

    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PeopleListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        $tasks = $person->tasks()
            ->with('taskCategory')
            ->get()
            ->map(fn (Task $task): array => [
                'id' => $task->id,
                'name' => $task->name,
                'due_at' => $task->due_at?->format('Y-m-d'),
                'task_category' => $task->taskCategory ? [
                    'id' => $task->taskCategory->id,
                    'name' => $task->taskCategory->name,
                    'color' => $task->taskCategory->color,
                ] : null,
            ]);

        $specialDates = $person->specialDates()
            ->where('should_be_reminded', true)
            ->orderBy('month')
            ->orderBy('day')
            ->get();

        $months = $specialDates
            ->pluck('month')
            ->unique()
            ->map(fn ($monthNumber): array => [
                'number' => $monthNumber,
                'name' => date('F', mktime(0, 0, 0, $monthNumber, 1)),
                'color' => $this->monthColors[$monthNumber],
                'reminders' => $specialDates
                    ->where('month', $monthNumber)
                    ->sortBy('day')
                    ->map(fn (SpecialDate $specialDate): array => [
                        'id' => $specialDate->id,
                        'day' => $specialDate->day,
                        'date' => $specialDate->date,
                        'name' => $specialDate->name,
                        'age' => $specialDate->age,
                    ]),
            ]);

        return view('persons.reminders.index', [
            'person' => $person,
            'persons' => $persons,
            'months' => $months,
            'totalReminders' => $specialDates->count(),
            'tasks' => $tasks,
        ]);
    }
}
