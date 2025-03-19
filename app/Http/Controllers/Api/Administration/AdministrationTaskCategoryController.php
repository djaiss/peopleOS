<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCategoryResource;
use App\Models\TaskCategory;
use App\Services\CreateTaskCategory;
use App\Services\DestroyTaskCategory;
use App\Services\UpdateTaskCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class AdministrationTaskCategoryController extends Controller
{
    public function index(): JsonResource
    {
        $taskCategories = TaskCategory::where('account_id', Auth::user()->account_id)
            ->get();

        return TaskCategoryResource::collection($taskCategories);
    }

    public function create(Request $request): JsonResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:30'],
        ]);

        $taskCategory = (new CreateTaskCategory(
            user: $request->user(),
            name: $data['name'],
            color: $data['color'],
        ))->execute();

        return new TaskCategoryResource($taskCategory);
    }

    public function update(Request $request, TaskCategory $taskCategory): JsonResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:30'],
        ]);

        $taskCategory = (new UpdateTaskCategory(
            user: $request->user(),
            taskCategory: $taskCategory,
            name: $data['name'],
            color: $data['color'],
        ))->execute();

        return new TaskCategoryResource($taskCategory);
    }

    public function destroy(Request $request, TaskCategory $taskCategory): Response
    {
        (new DestroyTaskCategory(
            user: $request->user(),
            taskCategory: $taskCategory,
        ))->execute();

        return response()->noContent();
    }
}
