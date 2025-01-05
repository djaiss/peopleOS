<?php

declare(strict_types=1);

namespace App\Livewire\Administration\Security;

use App\Models\User;
use App\Services\CreateApiKey;
use App\Services\DestroyApiKey;
use Illuminate\Support\Collection;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageApiKeys extends Component
{
    #[Locked]
    public int $userId;

    #[Locked]
    public User $user;

    #[Locked]
    public Collection $apiKeys;

    #[Validate('required|string|min:3|max:255')]
    public string $label = '';

    public bool $addMode = false;

    public function mount(): void
    {
        $this->user = User::find($this->userId);
        $this->apiKeys = collect($this->user->tokens
            ->map(fn (PersonalAccessToken $token): array => [
                'id' => $token->id,
                'name' => $token->name,
                'last_used' => $token->last_used_at ? $token?->last_used_at->diffForHumans() : trans('Never'),
                'just_added' => false,
                'token' => null,
            ]));
    }

    public function render()
    {
        return view('livewire.administration.security.manage-api-keys');
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
            'label' => 'required|string|min:3|max:255',
        ]);

        $plainTextToken = (new CreateApiKey(
            user: $this->user,
            label: $this->label,
        ))->execute();

        Toaster::success(__('API key created'));

        $this->reset('label');
        $this->toggleAddMode();

        $apiKey = $this->user->tokens->last();

        $this->apiKeys->push([
            'id' => $apiKey->id,
            'name' => $apiKey->name,
            'last_used' => trans('Never'),
            'just_added' => true,
            'token' => $plainTextToken,
        ]);
    }

    public function delete(int $apiKeyId): void
    {
        $apiKey = $this->user->tokens()->where('id', $apiKeyId)->first();

        (new DestroyApiKey(
            user: $this->user,
            tokenId: $apiKey->id,
        ))->execute();

        Toaster::success(__('API key deleted'));

        $this->apiKeys = $this->apiKeys->reject(fn (array $apiKey): bool => $apiKey['id'] === $apiKeyId);
    }
}
