<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Persons;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\TaskCategory;
use App\Services\CreateTask;
use App\Services\DestroyTask;
use App\Services\UpdateTask;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PersonTaskController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $person = $request->attributes->get('person');

        $tasks = $person->tasks()
            ->orderBy('created_at', 'desc')
            ->get();

        return new TaskCollection($tasks);
    }

    public function create(Request $request): JsonResource
    {
        $person = $request->attributes->get('person');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_completed' => ['required', 'boolean'],
            'due_at' => ['nullable', 'date'],
            'task_category_id' => ['nullable', 'exists:task_categories,id'],
        ]);

        $task = (new CreateTask(
            user: $request->user(),
            person: $person,
            name: $data['name'] ?? null,
            dueAt: $data['due_at'] ?? null,
            taskCategory: isset($data['task_category_id']) ? TaskCategory::find($data['task_category_id']) : null,
        ))->execute();

        return new TaskResource($task);
    }

    public function show(Request $request): JsonResource
    {
        $task = $request->attributes->get('task');

        return new TaskResource($task);
    }

    public function update(Request $request): JsonResource
    {
        $person = $request->attributes->get('person');
        $task = $request->attributes->get('task');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'due_at' => ['nullable', 'date'],
            'task_category_id' => ['nullable', 'exists:task_categories,id'],
        ]);

        $task = (new UpdateTask(
            user: Auth::user(),
            person: $person,
            task: $task,
            name: $data['name'],
            dueAt: $data['due_at'] ?? null,
            taskCategory: isset($data['task_category_id']) ? TaskCategory::find($data['task_category_id']) : null,
        ))->execute();

        return new TaskResource($task);
    }

    public function destroy(Request $request): Response
    {
        $task = $request->attributes->get('task');

        (new DestroyTask(
            user: Auth::user(),
            task: $task,
        ))->execute();

        return response()->noContent();
    }
}
