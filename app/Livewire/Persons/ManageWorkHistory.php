<?php

declare(strict_types=1);

namespace App\Livewire\Persons;

use App\Models\Person;
use App\Models\WorkHistory;
use App\Services\CreateWorkHistory;
use App\Services\DestroyWorkHistory;
use App\Services\UpdateWorkHistory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Masmerise\Toaster\Toaster;

class ManageWorkHistory
{
    public Collection $workHistories;

    public bool $addMode = false;

    #[Locked]
    public int $editedWorkHistoryId = 0;

    #[Locked]
    public Person $person;

    #[Validate('required|string|min:2|max:255')]
    public string $title = '';

    #[Validate('nullable|string|min:2|max:255')]
    public string $company = '';

    #[Validate('nullable|string|min:2|max:255')]
    public string $duration = '';

    #[Validate('nullable|string|min:2|max:255')]
    public ?string $salary = null;

    public bool $isCurrentJob = false;

    public function mount(Person $person): void
    {
        $this->person = $person;
        $this->workHistories = collect(WorkHistory::where('person_id', $person->id)
            ->get()
            ->map(fn (WorkHistory $history): array => [
                'id' => $history->id,
                'title' => $history->job_title,
                'company' => $history?->company_name,
                'duration' => $history?->duration,
                'salary' => $history?->estimated_salary,
                'is_current' => $history->active,
            ]));
    }

    public function render()
    {
        return view('livewire.persons.manage-work-history');
    }

    public function toggleAddMode(): void
    {
        $this->addMode = ! $this->addMode;
        $this->reset(['title', 'company', 'duration', 'salary', 'isCurrentJob']);
    }

    public function store(): void
    {
        $this->validate();

        $history = (new CreateWorkHistory(
            user: Auth::user(),
            person: $this->person,
            companyName: $this->company,
            jobTitle: $this->title,
            estimatedSalary: $this->salary,
            duration: $this->duration,
            active: $this->isCurrentJob,
        ))->execute();

        $this->workHistories->prepend([
            'id' => $history->id,
            'title' => $history->job_title,
            'company' => $history->company_name,
            'duration' => $history->duration,
            'salary' => $history->estimated_salary,
            'is_current' => $history->active,
        ]);

        $this->toggleAddMode();
        $this->dispatch('work-history-updated');

        Toaster::success(__('Work history entry created'));
    }

    public function toggleEditMode(int $historyId): void
    {
        $this->editedWorkHistoryId = $historyId;

        $history = $this->workHistories->firstWhere('id', $historyId);
        $this->title = $history['title'];
        $this->company = $history['company'];
        $this->duration = $history['duration'];
        $this->salary = $history['salary'];
        $this->isCurrentJob = $history['is_current'];
    }

    public function update(): void
    {
        $this->validate();

        $history = WorkHistory::where('id', $this->editedWorkHistoryId)->first();

        $history = (new UpdateWorkHistory(
            user: Auth::user(),
            workHistory: $history,
            companyName: $this->company,
            jobTitle: $this->title,
            estimatedSalary: $this->salary,
            duration: $this->duration,
            active: $this->isCurrentJob,
        ))->execute();

        $updatedHistory = [
            'id' => $history->id,
            'title' => $history->job_title,
            'company' => $history->company_name,
            'duration' => $history->duration,
            'salary' => $history->estimated_salary,
            'is_current' => $history->active,
        ];

        $this->workHistories = $this->workHistories->map(
            fn (array $existingHistory): array => $existingHistory['id'] === $this->editedWorkHistoryId ? $updatedHistory : $existingHistory
        );

        $this->resetEdit();
        $this->dispatch('work-history-updated');
        Toaster::success(__('Work history entry updated'));
    }

    public function resetEdit(): void
    {
        $this->editedWorkHistoryId = 0;
        $this->reset(['title', 'company', 'duration', 'salary', 'isCurrentJob']);
        $this->resetErrorBag();
    }

    public function delete(int $historyId): void
    {
        $history = WorkHistory::where('id', $historyId)->first();

        (new DestroyWorkHistory(
            user: Auth::user(),
            workHistory: $history,
        ))->execute();

        $this->workHistories = $this->workHistories->reject(fn (array $history): bool => $history['id'] === $historyId);
        Toaster::success(__('Work history entry deleted'));
    }
}
