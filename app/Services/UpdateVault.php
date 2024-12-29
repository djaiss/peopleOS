<?php

namespace App\Services;

use App\Cache\AccountVaultsCache;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateVault
{
    public function __construct(
        public User $user,
        public Vault $vault,
        public string $name,
        public ?string $description,
    ) {}

    public function execute(): Vault
    {
        $this->validate();
        $this->update();
        $this->clearCache();

        return $this->vault;
    }

    public function validate(): void
    {
        if ($this->vault->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException;
        }

        // make sure the user has the permission to delete the vault
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->vault->id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }
    }

    private function update(): void
    {
        $this->vault->name = $this->name;
        $this->vault->description = $this->description;
        $this->vault->save();
    }

    private function clearCache(): void
    {
        AccountVaultsCache::make(
            account: $this->user->account,
        )->refresh();
    }
}
