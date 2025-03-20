<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\TaskCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationPersonalizationController extends Controller
{
    public function index(): View
    {
        $genders = Gender::where('account_id', Auth::user()->account_id)
            ->orderBy('position')
            ->get()
            ->map(fn (Gender $gender): array => [
                'id' => $gender->id,
                'name' => $gender->name,
            ]);

        $taskCategories = TaskCategory::where('account_id', Auth::user()->account_id)
            ->get()
            ->map(fn (TaskCategory $taskCategory): array => [
                'id' => $taskCategory->id,
                'name' => $taskCategory->name,
                'color' => $taskCategory->color,
            ]);

        return view('administration.personalization.index', [
            'genders' => $genders,
            'taskCategories' => $taskCategories,
        ]);
    }
}
