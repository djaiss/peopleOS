<?php

declare(strict_types=1);

namespace App\Livewire\Administration;

use App\Models\User;
use App\Services\UpdateUserInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageProfile extends Component
{
    public string $first_name = '';

    public string $last_name = '';

    public ?string $nickname = '';

    public string $email = '';

    public ?string $born_at = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->nickname = $user->nickname;
        $this->email = $user->email;
        $this->born_at = $user->born_at?->format('m-d-Y');
    }

    public function render()
    {
        return view('livewire.administration.manage-profile');
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col space-y-2 mb-3">
                <div class="animate-pulse bg-slate-200 h-10 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-10 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-10 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-10 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-10 w-full rounded-xl"></div>
            </div>
        </div>
        HTML;
    }

    public function update(): void
    {
        $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(Auth::user()->id)],
            'born_at' => ['nullable', 'date'],
        ]);

        (new UpdateUserInformation(
            user: Auth::user(),
            email: $this->email,
            firstName: $this->first_name,
            lastName: $this->last_name,
            nickname: $this->nickname,
            bornedAt: $this->born_at,
        ))->execute();

        Toaster::success(__('Changes saved'));

        $this->dispatch('profile-updated');
    }
}
