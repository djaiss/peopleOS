<?php

declare(strict_types=1);

namespace App\Livewire\Administration\Personalization;

use App\Models\MaritalStatus;
use App\Services\CreateMaritalStatus;
use App\Services\DestroyMaritalStatus;
use App\Services\UpdateMaritalStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Masmerise\Toaster\Toaster;

class ManageMaritalStatuses
{
    public Collection $maritalStatuses;

    public bool $addMode = false;

    #[Locked]
    public int $editedMaritalStatusId = 0;

    #[Validate('required|string|min:3|max:255')]
    public string $name = '';

    #[Validate('required|integer|min:0')]
    public int $position = 0;

    public function mount(): void
    {
        $this->maritalStatuses = collect(MaritalStatus::where('account_id', Auth::user()->account_id)
            ->orderBy('position')
            ->get()
            ->map(fn (MaritalStatus $maritalStatus): array => [
                'id' => $maritalStatus->id,
                'name' => $maritalStatus->name,
            ]));
    }

    public function render()
    {
        return view('livewire.administration.personalization.manage-marital-statuses');
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col space-y-2 mb-3">
                <div class="animate-pulse bg-slate-200 h-8 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-8 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-8 w-full rounded-xl"></div>
            </div>
        </div>
        HTML;
    }

    public function toggleAddMode(): void
    {
        $this->addMode = ! $this->addMode;
    }

    public function store(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        $maritalStatus = (new CreateMaritalStatus(
            user: Auth::user(),
            name: $this->name,
        ))->execute();

        Toaster::success(__('Marital status created'));

        $this->toggleAddMode();
        $this->reset('name');

        $this->maritalStatuses->push([
            'id' => $maritalStatus->id,
            'name' => $maritalStatus->name,
        ]);
    }

    public function toggleEditMode(int $maritalStatusId): void
    {
        $this->editedMaritalStatusId = $maritalStatusId;

        $maritalStatus = $this->maritalStatuses->firstWhere('id', $maritalStatusId);
        $this->name = $maritalStatus['name'];
    }

    public function updatePosition(array $positions): void
    {
        foreach ($positions as $position) {
            $maritalStatus = MaritalStatus::find($position['id']);
            if ($maritalStatus && $maritalStatus->account_id === Auth::user()->account_id) {
                $maritalStatus->update([
                    'position' => $position['order'],
                ]);
            }
        }

        $this->maritalStatuses = collect(MaritalStatus::where('account_id', Auth::user()->account_id)
            ->orderBy('position')
            ->get()
            ->map(fn (MaritalStatus $maritalStatus): array => [
                'id' => $maritalStatus->id,
                'name' => $maritalStatus->name,
            ]));

        Toaster::success(__('Changes saved'));
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|max:100',
        ]);

        $maritalStatus = MaritalStatus::where('id', $this->editedMaritalStatusId)->first();

        $maritalStatus = (new UpdateMaritalStatus(
            user: Auth::user(),
            maritalStatus: $maritalStatus,
            name: $this->name,
            position: $maritalStatus->position,
        ))->execute();

        Toaster::success(__('Gender updated'));

        $maritalStatus = [
            'id' => $maritalStatus->id,
            'name' => $maritalStatus->name,
        ];

        $this->maritalStatuses = $this->maritalStatuses->map(fn (array $existingMaritalStatus): array => $existingMaritalStatus['id'] === $this->editedMaritalStatusId ? $maritalStatus : $existingMaritalStatus);

        $this->resetEdit();
    }

    public function resetEdit(): void
    {
        $this->editedMaritalStatusId = 0;
        $this->name = '';
        $this->resetErrorBag();
    }

    public function delete(int $maritalStatusId): void
    {
        $maritalStatus = MaritalStatus::where('id', $maritalStatusId)->first();

        (new DestroyMaritalStatus(
            user: Auth::user(),
            maritalStatus: $maritalStatus,
        ))->execute();

        Toaster::success(__('Marital status deleted'));

        $this->maritalStatuses = $this->maritalStatuses->reject(fn (array $maritalStatus): bool => $maritalStatus['id'] === $maritalStatusId);
    }
}
