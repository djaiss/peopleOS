<?php

namespace App\Livewire\Administration\Personalization;

use App\Models\Gender;
use App\Services\CreateGender;
use App\Services\DestroyGender;
use App\Services\UpdateGender;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;

class ManageGenders extends Component
{
    #[Locked]
    public Collection $genders;

    public bool $addMode = false;

    #[Locked]
    public int $editedGenderId = 0;

    #[Validate('required|string|min:3|max:255')]
    public string $name = '';

    public function mount(): void
    {
        $this->genders = collect(Gender::where('account_id', Auth::user()->account_id)
            ->orderBy('name')
            ->get()
            ->map(fn(Gender $gender): array => [
                'id' => $gender->id,
                'name' => $gender->name,
            ]));
    }

    public function render()
    {
        return view('livewire.administration.personalization.manage-genders');
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

        $gender = (new CreateGender(
            user: Auth::user(),
            name: $this->name,
        ))->execute();

        Toaster::success(__('Gender created'));

        $this->toggleAddMode();
        $this->reset('name');

        $this->genders->push([
            'id' => $gender->id,
            'name' => $gender->name,
        ]);
    }

    public function toggleEditMode(int $genderId): void
    {
        $this->editedGenderId = $genderId;

        $gender = $this->genders->firstWhere('id', $genderId);
        $this->name = $gender['name'];
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|max:100',
        ]);

        $gender = Gender::where('id', $this->editedGenderId)->first();

        $gender = (new UpdateGender(
            user: Auth::user(),
            gender: $gender,
            name: $this->name,
            position: $gender->position,
        ))->execute();

        Toaster::success(__('Gender updated'));

        $gender = [
            'id' => $gender->id,
            'name' => $gender->name,
        ];

        $this->genders = $this->genders->map(fn(array $existingGender): array => $existingGender['id'] === $this->editedGenderId ? $gender : $existingGender);

        $this->resetEdit();
    }

    public function resetEdit(): void
    {
        $this->editedGenderId = 0;
        $this->name = '';
        $this->resetErrorBag();
    }

    public function delete(int $genderId): void
    {
        $gender = Gender::where('id', $genderId)->first();

        (new DestroyGender(
            user: Auth::user(),
            gender: $gender,
        ))->execute();

        Toaster::success(__('Gender deleted'));

        $this->genders = $this->genders->reject(fn(array $gender): bool => $gender['id'] === $genderId);
    }
}
