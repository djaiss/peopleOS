<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\TaskCategory;
use App\Services\CreateTaskCategory;
use App\Services\DestroyTaskCategory;
use App\Services\UpdateTaskCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationTaskCategoryController extends Controller
{
    public function new(): View
    {
        return view('administration.personalization.partials.task-category-new');
    }

    public function create(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'color' => 'required|string|min:3|max:30',
        ]);

        (new CreateTaskCategory(
            user: Auth::user(),
            name: $validated['name'],
            color: $validated['color'],
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('status', __('Task category created'));
    }

    public function edit(Request $request, TaskCategory $taskCategory): View
    {
        if ($taskCategory->account_id !== Auth::user()->account_id) {
            abort(404);
        }

        return view('administration.personalization.partials.task-category-edit', [
            'taskCategory' => $taskCategory,
        ]);
    }

    public function update(Request $request, TaskCategory $taskCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'color' => 'required|string|min:3|max:30',
        ]);

        (new UpdateTaskCategory(
            user: Auth::user(),
            taskCategory: $taskCategory,
            name: $validated['name'],
            color: $validated['color'],
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('status', __('Task category updated'));
    }

    public function destroy(Request $request, TaskCategory $taskCategory): RedirectResponse
    {
        (new DestroyTaskCategory(
            user: Auth::user(),
            taskCategory: $taskCategory,
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('status', __('Task category deleted'));
    }
}
