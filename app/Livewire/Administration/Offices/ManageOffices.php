<?php

declare(strict_types=1);

namespace App\Livewire\Administration\Offices;

use App\Models\Office;
use App\Services\CreateOffice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageOffices extends Component
{
    #[Locked]
    public Collection $offices;

    public bool $addMode = false;

    #[Validate('required|string|min:3|max:255')]
    public string $name = '';

    public function mount(): void
    {
        $this->offices = collect(Office::where('account_id', Auth::user()->account_id)
            ->orderBy('name')
            ->get()
            ->map(fn (Office $office): array => [
                'id' => $office->id,
                'name' => $office->name,
            ]));
    }

    public function render()
    {
        return view('livewire.administration.offices.manage-offices');
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

        $office = (new CreateOffice(
            user: Auth::user(),
            name: $this->name,
        ))->execute();

        Toaster::success(__('Office created'));

        $this->toggleAddMode();
        $this->reset('name');

        $this->offices->push([
            'id' => $office->id,
            'name' => $office->name,
        ]);
    }
}
