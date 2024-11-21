<?php

namespace App\Livewire\Settings;

use App\Http\ViewModels\Settings\Personalization\EthnicityViewModel;
use App\Models\Account;
use App\Models\Ethnicity;
use App\Services\CreateEthnicity;
use App\Services\DestroyEthnicity;
use App\Services\UpdateEthnicity;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageEthnicities extends Component
{
    #[Locked]
    public Account $account;

    #[Locked]
    public int $accountId;

    #[Locked]
    public Collection $ethnicities;

    #[Locked]
    public int $editedEthnicityId = 0;

    public bool $addMode = false;

    #[Validate('required|string|min:3|max:100000')]
    public string $name = '';

    #[Validate('required|string|min:3|max:100000')]
    public string $editedName = '';

    public function mount()
    {
        $this->account = Account::find($this->accountId);
        $this->ethnicities = collect(EthnicityViewModel::index($this->account));
    }

    public function render()
    {
        return view('livewire.settings.manage-ethnicities', [
            'ethnicities' => $this->ethnicities,
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

    public function toggleAddMode()
    {
        $this->addMode = ! $this->addMode;
    }

    public function toggleEditMode(int $ethnicityId): void
    {
        $this->editedEthnicityId = $ethnicityId;

        $ethnicity = $this->ethnicities->firstWhere('id', $ethnicityId);
        $this->editedName = $ethnicity['label'];
    }

    public function store(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|max:100000',
        ]);

        $ethnicity = (new CreateEthnicity(
            user: Auth::user(),
            label: $this->name,
        ))->execute();

        $this->toggleAddMode();

        Toaster::success(__('Ethnicity created'));

        $ethnicity = EthnicityViewModel::ethnicity($ethnicity);

        $this->ethnicities = $this->ethnicities->push($ethnicity);
        $this->name = '';
    }

    public function update(int $ethnicityId): void
    {
        $this->validate([
            'editedName' => 'required|string|min:3|max:100000',
        ]);

        $ethnicity = Ethnicity::where('account_id', $this->account->id)
            ->findOrFail($ethnicityId);

        $ethnicity = (new UpdateEthnicity(
            user: Auth::user(),
            ethnicity: $ethnicity,
            label: $this->editedName,
        ))->execute();

        $this->resetEdit();

        Toaster::success(__('Ethnicity updated'));

        $ethnicity = EthnicityViewModel::ethnicity($ethnicity);

        $this->ethnicities = $this->ethnicities->map(fn (array $existingEthnicity) => $existingEthnicity['id'] === $ethnicityId ? $ethnicity : $existingEthnicity);
    }

    public function resetEdit(): void
    {
        $this->editedEthnicityId = 0;
        $this->editedName = '';
        $this->resetErrorBag();
    }

    public function delete(int $ethnicityId): void
    {
        $ethnicity = Ethnicity::where('account_id', $this->account->id)
            ->findOrFail($ethnicityId);

        (new DestroyEthnicity(
            user: Auth::user(),
            ethnicity: $ethnicity,
        ))->execute();

        Toaster::success(__('Ethnicity deleted'));

        $this->ethnicities = $this->ethnicities->reject(fn (array $ethnicity) => $ethnicity['id'] === $ethnicityId);
    }
}
