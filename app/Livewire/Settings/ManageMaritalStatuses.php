<?php

namespace App\Livewire\Settings;

use App\Http\ViewModels\Settings\Personalization\MaritalStatusViewModel;
use App\Models\Account;
use App\Models\MaritalStatus;
use App\Services\CreateMaritalStatus;
use App\Services\DestroyMaritalStatus;
use App\Services\UpdateMaritalStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageMaritalStatuses extends Component
{
    #[Locked]
    public Account $account;

    #[Locked]
    public int $accountId;

    #[Locked]
    public Collection $maritalStatuses;

    #[Locked]
    public int $editedMaritalStatusId = 0;

    public bool $addMode = false;

    #[Validate('required|string|min:3|max:100000')]
    public string $name = '';

    #[Validate('required|string|min:3|max:100000')]
    public string $editedName = '';

    public function mount(): void
    {
        $this->account = Account::find($this->accountId);
        $this->maritalStatuses = collect(MaritalStatusViewModel::index($this->account));
    }

    public function render()
    {
        return view('livewire.settings.manage-marital-statuses', [
            'maritalStatuses' => $this->maritalStatuses,
        ]);
    }

    public function placeholder()
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

    public function toggleEditMode(int $maritalStatusId): void
    {
        $this->editedMaritalStatusId = $maritalStatusId;

        $maritalStatus = $this->maritalStatuses->firstWhere('id', $maritalStatusId);
        $this->editedName = $maritalStatus['label'];
    }

    public function store(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|max:100000',
        ]);

        $maritalStatus = (new CreateMaritalStatus(
            user: Auth::user(),
            label: $this->name,
        ))->execute();

        $this->toggleAddMode();

        Toaster::success(__('Marital status created'));

        $maritalStatus = MaritalStatusViewModel::maritalStatus($maritalStatus);

        $this->maritalStatuses = $this->maritalStatuses->push($maritalStatus);
        $this->name = '';
    }

    public function update(int $maritalStatusId): void
    {
        $this->validate([
            'editedName' => 'required|string|min:3|max:100000',
        ]);

        $maritalStatus = MaritalStatus::where('account_id', $this->account->id)
            ->findOrFail($maritalStatusId);

        $maritalStatus = (new UpdateMaritalStatus(
            user: Auth::user(),
            maritalStatus: $maritalStatus,
            label: $this->editedName,
        ))->execute();

        $this->resetEdit();

        Toaster::success(__('Marital status updated'));

        $maritalStatus = MaritalStatusViewModel::maritalStatus($maritalStatus);

        $this->maritalStatuses = $this->maritalStatuses->map(fn (array $existingMaritalStatus) => $existingMaritalStatus['id'] === $maritalStatusId ? $maritalStatus : $existingMaritalStatus);
    }

    public function resetEdit(): void
    {
        $this->editedMaritalStatusId = 0;
        $this->editedName = '';
        $this->resetErrorBag();
    }

    public function delete(int $maritalStatusId): void
    {
        $maritalStatus = MaritalStatus::where('account_id', $this->account->id)
            ->findOrFail($maritalStatusId);

        (new DestroyMaritalStatus(
            user: Auth::user(),
            maritalStatus: $maritalStatus,
        ))->execute();

        Toaster::success(__('Marital status deleted'));

        $this->maritalStatuses = $this->maritalStatuses->reject(fn (array $maritalStatus) => $maritalStatus['id'] === $maritalStatusId);
    }
}
