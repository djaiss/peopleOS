<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\ToggleTask;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ToggleTaskController extends Controller
{
    public function update(Request $request): JsonResource
    {
        $id = (int) $request->route()->parameter('task');

        $task = Task::where('account_id', Auth::user()->account_id)
            ->with('taskCategory')
            ->findOrFail($id);

        (new ToggleTask(
            user: Auth::user(),
            task: $task,
        ))->execute();

        return new TaskResource($task->refresh());
    }
}
