<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Cache\PeopleListCache;
use App\Http\Controllers\Controller;
use App\Models\WorkHistory;
use App\Services\CreateWorkHistory;
use App\Services\DestroyWorkHistory;
use App\Services\UpdateWorkHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonWorkController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PeopleListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        $workHistories = WorkHistory::where('person_id', $person->id)
            ->get()
            ->map(fn (WorkHistory $history): array => [
                'id' => $history->id,
                'title' => $history->job_title,
                'company' => $history?->company_name,
                'duration' => $history?->duration,
                'salary' => $history?->estimated_salary,
                'is_current' => $history->active,
            ]);

        return view('persons.work.index', [
            'persons' => $persons,
            'person' => $person,
            'workHistories' => $workHistories,
        ]);
    }

    public function new(Request $request): View
    {
        $person = $request->attributes->get('person');

        return view('persons.work.partials.work-add', [
            'person' => $person,
        ]);
    }

    public function create(Request $request)
    {
        $person = $request->attributes->get('person');

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'company' => 'nullable|string|min:3|max:255',
            'duration' => 'nullable|string|min:3|max:255',
            'salary' => 'nullable|string|min:3|max:255',
            'is_current' => 'nullable',
        ]);

        $active = false;
        if (array_key_exists('is_current', $validated) && ($validated['is_current'] === 'on' || $validated['is_current'] === '1')) {
            $active = true;
        }

        (new CreateWorkHistory(
            user: Auth::user(),
            person: $person,
            companyName: $validated['company'],
            jobTitle: $validated['title'],
            estimatedSalary: $validated['salary'],
            duration: $validated['duration'],
            active: $active,
        ))->execute();

        return redirect()->route('persons.work.index', $person->slug)
            ->with('status', trans('The work history has been created'));
    }

    public function edit(Request $request): View
    {
        $person = $request->attributes->get('person');
        $workHistoryId = (int) $request->route()->parameter('entry');

        $workHistory = WorkHistory::where('person_id', $person->id)
            ->findOrFail($workHistoryId);

        return view('persons.work.partials.work-edit', [
            'person' => $person,
            'workHistory' => $workHistory,
        ]);
    }

    public function update(Request $request)
    {
        $person = $request->attributes->get('person');
        $workHistoryId = (int) $request->route()->parameter('entry');

        $workHistory = WorkHistory::where('person_id', $person->id)
            ->findOrFail($workHistoryId);

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'company' => 'nullable|string|min:3|max:255',
            'duration' => 'nullable|string|min:3|max:255',
            'salary' => 'nullable|string|min:3|max:255',
            'is_current' => 'nullable',
        ]);

        $active = false;
        if (array_key_exists('is_current', $validated) && ($validated['is_current'] === 'on' || $validated['is_current'] === 1)) {
            $active = true;
        }

        (new UpdateWorkHistory(
            user: Auth::user(),
            workHistory: $workHistory,
            companyName: $validated['company'],
            jobTitle: $validated['title'],
            estimatedSalary: $validated['salary'],
            duration: $validated['duration'],
            active: $active,
        ))->execute();

        return redirect()->route('persons.work.index', $person->slug)
            ->with('status', trans('The work history has been updated'));
    }

    public function destroy(Request $request)
    {
        $person = $request->attributes->get('person');
        $workHistoryId = (int) $request->route()->parameter('entry');

        $workHistory = WorkHistory::where('person_id', $person->id)
            ->findOrFail($workHistoryId);

        (new DestroyWorkHistory(
            user: Auth::user(),
            workHistory: $workHistory,
        ))->execute();

        return redirect()->route('persons.work.index', $person->slug)
            ->with('status', trans('The work history has been deleted'));
    }
}
