<?php

namespace App\Services;

use App\Cache\AccountVaultsCache;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyVault
{
    public function __construct(
        public User $user,
        public Vault $vault,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->vault->delete();
        $this->clearCache();
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

    private function clearCache(): void
    {
        AccountVaultsCache::make(
            account: $this->user->account,
        )->refresh();
    }
}
