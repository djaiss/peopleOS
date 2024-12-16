<?php

namespace App\Livewire\Settings;

use App\Http\ViewModels\Settings\Personalization\GenderViewModel;
use App\Models\Account;
use App\Models\Gender;
use App\Services\CreateGender;
use App\Services\DestroyGender;
use App\Services\UpdateGender;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageGenders extends Component
{
    #[Locked]
    public Account $account;

    #[Locked]
    public int $accountId;

    #[Locked]
    public Collection $genders;

    #[Locked]
    public int $editedGenderId = 0;

    public bool $addMode = false;

    #[Validate('required|string|min:3|max:100000')]
    public string $name = '';

    #[Validate('required|string|min:3|max:100000')]
    public string $editedName = '';

    public function mount(): void
    {
        $this->account = Account::find($this->accountId);
        $this->genders = collect(GenderViewModel::index($this->account));
    }

    public function render()
    {
        return view('livewire.settings.manage-genders', [
            'genders' => $this->genders,
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

    public function toggleEditMode(int $genderId): void
    {
        $this->editedGenderId = $genderId;

        $gender = $this->genders->firstWhere('id', $genderId);
        $this->editedName = $gender['label'];
    }

    public function store(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|max:100000',
        ]);

        $gender = (new CreateGender(
            user: Auth::user(),
            label: $this->name,
        ))->execute();

        $this->toggleAddMode();

        Toaster::success(__('Gender created'));

        $gender = GenderViewModel::gender($gender);

        $this->genders = $this->genders->push($gender);
        $this->name = '';
    }

    public function update(int $genderId): void
    {
        $this->validate([
            'editedName' => 'required|string|min:3|max:100000',
        ]);

        $gender = Gender::where('account_id', $this->account->id)
            ->findOrFail($genderId);

        $gender = (new UpdateGender(
            user: Auth::user(),
            gender: $gender,
            label: $this->editedName,
            position: $gender['position'],
        ))->execute();

        $this->resetEdit();

        Toaster::success(__('Gender updated'));

        $gender = GenderViewModel::gender($gender);

        $this->genders = $this->genders->map(fn (array $existingGender) => $existingGender['id'] === $genderId ? $gender : $existingGender);
    }

    public function resetEdit(): void
    {
        $this->editedGenderId = 0;
        $this->editedName = '';
        $this->resetErrorBag();
    }

    public function delete(int $genderId): void
    {
        $gender = Gender::where('account_id', $this->account->id)
            ->findOrFail($genderId);

        (new DestroyGender(
            user: Auth::user(),
            gender: $gender,
        ))->execute();

        Toaster::success(__('Gender deleted'));

        $this->genders = $this->genders->reject(fn (array $gender) => $gender['id'] === $genderId);
    }
}
