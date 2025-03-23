<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\TaskCategory;
use App\Services\CreateTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonTaskController extends Controller
{
    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');
        $taskCategories = Auth::user()->account->taskCategories;

        return view('persons.reminders.partials.task-add', [
            'person' => $person,
            'taskCategories' => $taskCategories,
        ]);
    }

    public function create(Request $request)
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'due_at' => 'required|string',
            'task_category_id' => 'nullable|exists:task_categories,id',
            'has_due_date' => 'sometimes',
            'has_category' => 'sometimes',
        ]);

        $dueAt = $request->has('has_due_date') ? $validated['due_at'] : null;
        $taskCategory = $request->has('has_category') ? TaskCategory::find($validated['task_category_id']) : null;

        (new CreateTask(
            user: Auth::user(),
            person: $person,
            name: $validated['name'],
            dueAt: $dueAt,
            taskCategory: $taskCategory,
        ))->execute();

        return redirect()->route('persons.reminders.index', $person->slug)
            ->with('status', trans('The task has been created'));
    }
}
