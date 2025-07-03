<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCategoryResource;
use App\Models\TaskCategory;
use App\Services\CreateTaskCategory;
use App\Services\DestroyTaskCategory;
use App\Services\UpdateTaskCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdministrationTaskCategoryController extends Controller
{
    use ApiResponses;

    public function index(): JsonResource
    {
        $taskCategories = TaskCategory::where('account_id', Auth::user()->account_id)
            ->get();

        return TaskCategoryResource::collection($taskCategories);
    }

    public function create(Request $request): JsonResponse
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

        return (new TaskCategoryResource($taskCategory))->response()->setStatusCode(201);
    }

    public function show(TaskCategory $taskCategory): JsonResource|JsonResponse
    {
        if ($taskCategory->account_id !== Auth::user()->account_id) {
            return $this->error('Task category not found', 404);
        }

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
